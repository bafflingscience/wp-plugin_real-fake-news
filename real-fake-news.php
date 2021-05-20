<?php
/**
 * Plugin Name: REAL FAKE NEWS
 * Plugin URI: https://goodtech.tips
 * Author: g o o d t e c h . t i p s
 * Author URI: https://goodtech.tips
 * Description: Pulls in the latest propaganda from the sources you know you can't trust. Pulled in via newsapi.org
 * Version: 1.0.0
 * Licencse: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: real-fake-news
 * Domain Path: /languages
 */
defined ('ABSPATH') or die;

require_once( ABSPATH . 'wp-admin/includes/upgrade.php');

// ADD PLUGIN MENU
add_action('admin_menu', 'news_add_menu_page');
function news_add_menu_page()
{
    add_menu_page(
        'Real Fake News',
        'RFNEWS',
        'manage_options',
        'real-fake-news.php',
        'run_all',
        'dashicons-book',
        16,
    );
}

function run_all() {
	
    if ( false === get_option( 'newsapi_db_info' ) ) {  
        
        //* assign variable to get_news_api() function *//
        $info_news = get_news_api();
        
        //* Save API call as a Transient *//
        add_option( 'newsapi_db_info', $info_news );
        return;
        
	}

    //* Custom TABLES *//
    if (false === get_option('newsapi_db_version')) {
        create_database_table();
    }
        //* Get info stored in the database *//
        save_database_table_info();
}

function get_news_api()
{
    include_once('configlurmaychun.php');
    
    $apiurl = $_APIURL;

    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'body' => array(),
    );

    $response = wp_remote_get($apiurl, $args);
    $response_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if (401 === $response_code) {
        return "Unauthorized Access";
    }
    if (200 !== $response_code) {
        return "Fucking Ping Error";
    }
    if (200 === $response_code) {
        return $body;
    }
}

//? https://codex.wordpress.org/Creating_Tables_with_Plugins *//

function create_database_table()
{
    //? https://developer.wordpress.org/reference/classes/wpdb *//
    global $wpdb;
    global $newsapi_db_version;
    
    $newsapi_db_version = '1.0.0';
    
    //* create db table called 'fake_fucking_news' with prefix (DEFAULT is wp_) *//
    $table_name = $wpdb->prefix . "fake_fucking_news";
    
	$charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        source varchar(50),
        author text(30),
        title varchar(125),
        articleDescription varchar(255),
        articleUrl varchar(255),
        urlToImage varchar(125),
        publishedAt datetime DEFAULT '00-00-0000 00:00:00' NOT NULL,
        PRIMARY KEY  (id)
) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    //* Save API call as a Transient *//
    add_option('newsapi_db_version', $newsapi_db_version);
}

function save_database_table_info()
{
    global $wpdb;
    
    $table_name = $wpdb->prefix . "fake_fucking_news";
    
    $articles = ( json_decode(get_option('newsapi_db_info')) )->articles;
    // $article = unique_associative_array($articles, 'article_url');
    
	foreach ($articles as $article) {
        $wpdb->insert(
            $table_name,
            array(
                'source'             => $article->source->name,
                'author'             => $article->author,
                'title'              => $article->title,
                'articleDescription' => $article->description,
                'articleUrl'         => $article->url,
                'urlToImage'         => $article->urlToImage,
                'publishedAt'        => $article->publishedAt,
                )
            );
             '<pre>';
            var_dump( $articles );
            '</pre>';
        }
    }
