<?php

namespace Drupal\demo_pages;

use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;

class WSPosts {

  protected $client;

  protected $base_url;

  public function __construct(Client $client, ConfigFactory $config) {

    $this->client = $client;
    $this->base_url = $config->get('demo_pages.settings')->get('demo_pages_ws_posts_url');

  }

  public function getPosts(){
    $request = $this->client->get( $this->base_url . 'posts');
    return json_decode($request->getBody());
  }

  public function getPost($post_id) {
    $request = $this->client->get( $this->base_url . 'posts/' . $post_id);
    return json_decode($request->getBody());
  }
}