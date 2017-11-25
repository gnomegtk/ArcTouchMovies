<?php

namespace controllers;

use libraries\TMDb;

/**
 * Description of Main
 *
 * @author Evandro Veloso Gomes <gnome_gtk2000@yahoo.com.br>
 */
class Main {
    public function index() {
        global $config;

        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$page) {
            $page = 1;
        }

        $TMDb = new TMDb($config['TMDb']);
        list($movies, $total_pages) = $TMDb->getUpcoming();
        $movies_fields = array_keys((array) $movies[0]);

        $genres = $TMDb->getGenres();

        include __VIEWS_DIR__ . 'index.php';
    }

    public function movie() {
        global $config;

        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

        $TMDb = new TMDb($config['TMDb']);
        $movie_data = (array) $TMDb->getMovie($id);

        include __VIEWS_DIR__ . 'movie.php';
    }
}
