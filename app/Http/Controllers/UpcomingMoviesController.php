<?php

namespace App\Http\Controllers;


use App\Repositories\UpcomingMoviesRepository;

class UpcomingMoviesController extends Controller
{
    private $upcomingMoviesRepository;

    public function __construct(UpcomingMoviesRepository $upcomingMoviesRepository)
    {
        $this->upcomingMoviesRepository = $upcomingMoviesRepository;
    }

    public function index()
    {
        return response()->json($this->upcomingMoviesRepository->getAllUpcomingMovies());
    }
}