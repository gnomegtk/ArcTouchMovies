<?php

namespace libraries;

/**
 * Description of TMDb
 *
 * @author Evandro Veloso Gomes <gnome_gtk2000@yahoo.com.br>
 */
class TMDb {
    private $url;
    private $key;

    public function __construct($config) {
        $this->url = $config['url'];
        $this->key = $config['key'];
    }

    /**
     * Encapsulates the request with the adequate options
     * 
     * @param string $url   URL for request
     * @return object
     * @throws \Exception
     */
    private function request($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $url . "?language=en-US&api_key=" . $this->key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new \Exception("Error getting the information from TMDb: " . $err);
        } else {
            return json_decode($response);
        }
    }

    /**
     * Get the upcoming movies
     * 
     * @param int $page Index of the pagination
     * 
     * @return array
     */
    public function getUpcoming($page = 1) {

        $data = $this->request("movie/upcoming?page=$page");

        return array($data->results, $data->total_pages);
    }

    /**
     * Get the genres' movies
     * 
     * @return array
     */
    public function getGenres() {

        $data = $this->request("genre/movie/list");

        $genres = array();
        foreach($data->genres as $genre) {
            $genres[$genre->id] = $genre->name;
        }

        return $genres;
    }

    /**
     * Get the details of the movie
     * 
     * @param int $id
     * 
     * @return array
     */
    public function getMovie($id) {
        return $this->request("movie/" . $id);
    }
}
