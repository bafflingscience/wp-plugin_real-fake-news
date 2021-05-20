<?php

include_once( 'real-fake-news.php' );

global $wpdb;

$table_name = $wpdb->prefix . 'fake_fucking_news';

$sql = "SELECT * FROM $table_name";
$sql = "SELECT DISTINCT articleUrl, urlToImage, title, articleDescription FROM $table_name;";

$table_info = $wpdb->get_results($sql);

foreach ($table_info as $info_row) {
      echo $info_row->source->name;
      echo $info_row->author;
      echo $info_row->title; 
      echo $info_row->description; 
      echo $info_row->articleUrl; 
      echo $info_row->publishedAt; 
  }
