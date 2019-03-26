<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Promise;

class TmdbApiService
{
    const ROOT_URL = 'https://api.themoviedb.org/3';
    const UPCOMING_MOVIES_PATH = '/movie/upcoming';
    const GENRES_PATH = '/genre/movie/list';
    const IMAGE_BASE_URL = 'http://image.tmdb.org/t/p/w500/';

    private $api_key = null;
    private $region = null;
    private $language = null;
    private $httpClient = null;
    private $genreList = null;

    /**
     * TmdbApiService constructor.
     * @param string $region
     */
    public function __construct($region = 'US', $language = 'en-US')
    {
        $this->api_key = config('app.TMDB_API_KEY');
        $this->region = $region;
        $this->language = $language;
        $this->httpClient = new Client(['timeout' => 5]);
    }

    /**
     * @param int $page
     * @return mixed
     */
    private function getUpcomingMoviesPage($page = 1)
    {
        $queryParams = \GuzzleHttp\Psr7\build_query([
            'api_key' => $this->api_key,
            'region' => $this->region,
            'language' => $this->language,
            'page' => $page
        ]);

        $url = implode('', [
            static::ROOT_URL,
            static::UPCOMING_MOVIES_PATH,
            '?',
            $queryParams
        ]);

        $options = ['headers' => ['Accept' => 'application/json']];

        return $this->makeRequest('GET', $url, $options);
    }

    /**
     * @param $method
     * @param $url
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    private function makeRequest($method, $url, $options = [])
    {
        return new Request($method, $url, $options);
    }

    /**
     * @return mixed
     */
    public function getAllUpcomingMovies()
    {
        $response = $this->httpClient->send($this->getUpcomingMoviesPage());
        $page1 = json_decode($response->getBody()->getContents());

        $records = array_map(function ($item) {
            $this->setImageAndGenres($item);
            return $item;
        }, $page1->results);

        if ($page1->total_pages > 1) {
            $promises = [];

            for ($i = 2; $i <= $page1->total_pages; $i++) {
                $promises[] = $this->httpClient->sendAsync($this->getUpcomingMoviesPage($i, true));
            }

            $results = Promise\unwrap($promises);

            foreach ($results as $result) {
                array_map(function ($item) use (&$records) {
                    $this->setImageAndGenres($item);
                    $records[] = $item;
                }, json_decode($result->getBody()->getContents())->results);
            }

        }

        return $records;
    }

    /**
     * @param $movie
     * @return mixed
     */
    private function setImageAndGenres(&$movie)
    {
        $movie->image_path = static::IMAGE_BASE_URL . $movie->poster_path ?? $movie->backdrop_path;
        $movie->genres = $this->loadGenres($movie->genre_ids);
    }

    /**
     * @param $genres
     * @return array
     */
    private function loadGenres($genres)
    {
        if (!$this->genreList) {
            $this->getGenreList();
        }

        return array_map(function ($genre) {
            foreach ($this->genreList as $g) {
                if ($g->id === $genre) {
                    return $g->name;
                }
            }
        }, $genres);
    }

    /**
     * Get GenreList from TMDB
     */
    private function getGenreList()
    {
        $queryParams = \GuzzleHttp\Psr7\build_query([
            'api_key' => $this->api_key,
            'language' => $this->language
        ]);

        $url = implode('', [
            static::ROOT_URL,
            static::GENRES_PATH,
            '?',
            $queryParams
        ]);

        $response = $this->httpClient->send($this->makeRequest('GET', $url));

        $this->genreList = json_decode($response->getBody()->getContents())->genres;
    }

}
