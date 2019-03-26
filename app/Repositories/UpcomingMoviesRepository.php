<?php

namespace App\Repositories;


use App\Services\TmdbApiService;

class UpcomingMoviesRepository
{
    private $tmdbApiService = null;

    public function __construct(TmdbApiService $tmdbApiService)
    {
        $this->tmdbApiService = $tmdbApiService;
    }

    public function getAllUpcomingMovies()
    {
        return $this->tmdbApiService->getAllUpcomingMovies();
    }

}