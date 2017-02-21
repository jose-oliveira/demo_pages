<?php

namespace Drupal\demo_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\demo_pages\WSPosts;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for demo pages routes.
 */
class DemoWSController extends ControllerBase {

  protected $ws_posts;

  public function __construct(WSPosts $ws_posts) {

    $this->ws_posts = $ws_posts;

  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('demo_pages.ws_posts')
    );
  }

  public function posts() {
    $posts = $this->ws_posts->getPosts();

    $posts_titles = [];
    foreach ($posts as $post) {
      $posts_titles[] = Link::createFromRoute($post->title, 'demo_pages_ws_post', array('post_id' => $post->id));
    }

    $posts_per_page = 10;
    $current_page = pager_default_initialize(count($posts_titles), $posts_per_page);
    $pages = array_chunk($posts_titles, $posts_per_page, TRUE);

    $elements['list'] = array(
      '#theme' => 'item_list',
      '#items' => $pages[$current_page],
    );

    $elements['pager'] = array(
      '#type' => 'pager',
    );

    return $elements;
  }

  public function post($post_id) {

    $post = $this->ws_posts->getPost($post_id);

    $elements['title'] = array(
      '#type' => 'html_tag',
      '#tag' => 'h1',
      '#value' => $post->title,
    );


    $elements['body'] = array(
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => $post->body,
    );

    return $elements;
  }
}