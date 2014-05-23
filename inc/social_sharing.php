<?php
defined('ABSPATH') or die("Cheating........Uh!!");
/**
 * File contains the functions necessary for Social Sharing functionality
 */

/**
 * Render sharing interface html.
 */
function the_champ_prepare_sharing_html($postUrl, $sharingType = 'horizontal'){
	global $theChampSharingOptions, $post;
	$html = '';
	if(isset($theChampSharingOptions[$sharingType.'_re_providers'])){
		$html = '<ul class="the_champ_sharing_ul">';
		foreach($theChampSharingOptions[$sharingType.'_re_providers'] as $provider){
			$html .= '<li>';
			if(isset($theChampSharingOptions[$sharingType.'_counts'])){
				$html .= '<span class="the_champ_share_count the_champ_'.$provider.'_count">&nbsp;</span>';
			}
			if($provider == 'print'){
				$html .= '<i alt="Print" Title="Print" class="theChampSharingButton theChampSharing'. ucfirst($provider) .'Button" onclick=\'window.print()\'></i>';
			}elseif($provider == 'email'){
				$html .= '<i alt="Email" Title="Email" class="theChampSharingButton theChampSharing'. ucfirst($provider) .'Button" onclick="window.location.href = \'mailto:?subject=\' + escape(\'Have a look at this website\') + \'&body=\' + escape(\''.$postUrl.'\')"></i>';
			}else{
				if($provider == 'facebook'){
					$sharingUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . $postUrl;
				}elseif($provider == 'twitter'){
					$sharingUrl = 'http://twitter.com/intent/tweet?text='.urlencode($post->post_title).'&url=' . $postUrl;
				}elseif($provider == 'linkedin'){
					$sharingUrl = 'http://www.linkedin.com/shareArticle?mini=true&url=' . $postUrl;
				}elseif($provider == 'google'){
					$sharingUrl = 'https://plus.google.com/share?url=' . $postUrl;
				}elseif($provider == 'yahoo'){
					$sharingUrl = 'http://bookmarks.yahoo.com/toolbar/SaveBM/?u=' . $postUrl . '&t=' . urlencode($post->post_title);
				}elseif($provider == 'reddit'){
					$sharingUrl = 'http://reddit.com/submit?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'digg'){
					$sharingUrl = 'http://digg.com/submit?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'delicious'){
					$sharingUrl = 'http://del.icio.us/post?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'stumbleupon'){
					$sharingUrl = 'http://www.stumbleupon.com/submit?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'float it'){
					$sharingUrl = 'http://www.designfloat.com/submit.php?url='.$postUrl.'&title=' . urlencode($post->post_title);
				}elseif($provider == 'tumblr'){
					$sharingUrl = 'http://www.tumblr.com/share?v=3&u='.urlencode($postUrl).'&t=' . urlencode($post->post_title) . '&s=';
				}elseif($provider == 'vkontakte'){
					$sharingUrl = 'http://vkontakte.ru/share.php?&url='.urlencode($postUrl);
				}elseif($provider == 'pinterest'){
					$sharingUrl = "javascript:void((function(){var e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
				}
				$html .= '<i alt="'.($provider == 'google' ? 'Google Plus' : ucfirst($provider)).'" Title="'.($provider == 'google' ? 'Google Plus' : ucfirst($provider)).'" class="theChampSharingButton theChampSharing'. ucfirst( str_replace(' ', '', $provider) ) .'Button" ';
				if($provider == 'pinterest'){
					$html .= 'onclick="'.$sharingUrl.'"></i>';
				}else{
					$html .= 'onclick=\' theChampPopup("'.$sharingUrl.'")\'></i>';
				}
			}
			$html .= '</li>';
		}
		$html .= '<li>';
		if(isset($theChampSharingOptions[$sharingType.'_counts'])){
			$html .= '<span class="the_champ_share_count">&nbsp;</span>';
		}
		$html .= '<i style="display: inline !important; visibility: visible !important" title="More" alt="More" class="theChampSharingButton theChampSharingMoreButton" onclick="theChampMoreSharingPopup(this, \''.$postUrl.'\', \''.urlencode($post->post_title).'\')" ></i></li></ul><div style="clear:both"></div>';
	}
	return $html;
}

$theChampVerticalHomeCount = 0;
$theChampVerticalExcerptCount = 0;
/**
 * Enable sharing interface at selected areas.
 */
function the_champ_render_sharing($content){
	global $post;
	$sharingMeta = get_post_meta($post->ID, '_the_champ_meta', true);
	global $theChampSharingOptions;
	$postUrl = get_permalink($post->ID);
	if(isset($theChampSharingOptions['hor_enable']) && !(isset($sharingMeta['sharing']) && $sharingMeta['sharing'] == 1 && !is_front_page())){
		$sharingDiv = the_champ_prepare_sharing_html($postUrl);
		$horizontalDiv = "<div class='the_champ_sharing_container the_champ_horizontal_sharing' super-socializer-data-href='".$postUrl."'><div style='font-weight:bold'>".ucfirst($theChampSharingOptions['title'])."</div>".$sharingDiv."</div>";
		// show horizontal sharing		
		if((isset( $theChampSharingOptions['home']) && is_front_page()) || (isset( $theChampSharingOptions['category']) && is_category()) || ( isset( $theChampSharingOptions['post'] ) && is_single() ) || ( isset( $theChampSharingOptions['page'] ) && is_page() ) || ( isset( $theChampSharingOptions['excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' )){	
			if(isset($theChampSharingOptions['top'] ) && isset($theChampSharingOptions['bottom'])){
				$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
			}else{
				if(isset($theChampSharingOptions['top'])){
					$content = $horizontalDiv.$content;
				}elseif(isset($theChampSharingOptions['bottom'])){
					$content = $content.$horizontalDiv;
				}
			}
		}
	}
	if(isset($theChampSharingOptions['vertical_enable']) && !(isset($sharingMeta['vertical_sharing']) && $sharingMeta['vertical_sharing'] == 1 && !is_front_page())){
		$sharingDiv = the_champ_prepare_sharing_html($postUrl, 'vertical');
		$verticalDiv = "<div class='the_champ_sharing_container the_champ_vertical_sharing' style='".(isset($theChampSharingOptions['left_offset']) && $theChampSharingOptions['left_offset'] != '' ? 'left: '.$theChampSharingOptions['left_offset'].'px;' : '').(isset($theChampSharingOptions['top_offset']) && $theChampSharingOptions['top_offset'] != '' ? 'top: '.$theChampSharingOptions['top_offset'].'px;' : '')."' super-socializer-data-href='".$postUrl."'>".$sharingDiv."</div>";
		// show vertical sharing
		if((isset( $theChampSharingOptions['vertical_home']) && is_front_page()) || (isset( $theChampSharingOptions['vertical_category']) && is_category()) || ( isset( $theChampSharingOptions['vertical_post'] ) && is_single() ) || ( isset( $theChampSharingOptions['vertical_page'] ) && is_page() ) || ( isset( $theChampSharingOptions['vertical_excerpt'] ) && is_front_page() && current_filter() == 'get_the_excerpt' )){
			if(is_front_page()){
				global $theChampVerticalHomeCount, $theChampVerticalExcerptCount;
				if(current_filter() == 'the_content'){
					$var = 'theChampVerticalHomeCount';
				}elseif(current_filter() == 'get_the_excerpt'){
					$var = 'theChampVerticalExcerptCount';
				}
				if($$var == 0){
					$content = $content.$verticalDiv;
					$$var++;
				}
			}else{
				$content = $content.$verticalDiv;
			}
		}
	}
	return $content;
}
add_filter('the_content', 'the_champ_render_sharing');
add_filter('get_the_excerpt', 'the_champ_render_sharing');

/**
 * Get sharing count for providers
 */
function the_champ_sharing_count(){
	if(isset($_GET['urls']) && count($_GET['urls']) > 0){
		$targetUrls = array_unique($_GET['urls']);
	}else{
		the_champ_ajax_response(0, __('Invalid request'));
	}
	global $theChampSharingOptions;
	// no providers selected
	if(!isset($theChampSharingOptions['providers']) || count($theChampSharingOptions['providers']) == 0){
		the_champ_ajax_response(0, __('Providers not selected'));
	}
	$responseData = array();
	foreach($targetUrls as $targetUrl){
		foreach($theChampSharingOptions['providers'] as $provider){
			switch($provider){
				case 'facebook':
					$url = 'http://graph.facebook.com/?id=' . $targetUrl;
					break;
				case 'twitter':
					$url = 'http://urls.api.twitter.com/1/urls/count.json?url=' . $targetUrl;
					break;
				case 'linkedin':
					$url = 'http://www.linkedin.com/countserv/count/share?url='. $targetUrl .'&format=json';
					break;
				case 'reddit':
					$url = 'http://www.reddit.com/api/info.json?url='. $targetUrl;
					break;
				case 'delicious':
					$url = 'http://feeds.delicious.com/v2/json/urlinfo/data?url='. $targetUrl;
					break;
				case 'pinterest':
					$url = 'http://api.pinterest.com/v1/urls/count.json?callback=theChamp&url='. $targetUrl;
					break;
				case 'stumbleupon':
					$url = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url='. $targetUrl;
					break;
				case 'google':
					$url = 'http://share.yandex.ru/gpp.xml?url='. $targetUrl;
					break;
				default:
					$url = '';
			}
			if($url == '') { continue; }
			$response = wp_remote_get( $url,  array( 'timeout' => 15 ) );
			if( ! is_wp_error( $response ) && isset( $response['response']['code'] ) && 200 === $response['response']['code'] ){
				$body = wp_remote_retrieve_body( $response );
				if($provider == 'pinterest'){
					$body = str_replace(array('theChamp(', ')'), '', $body);
				}
				if($provider != 'google'){
					$body = json_decode($body);
				}
				switch($provider){
					case 'facebook':
						if(!empty($body -> shares)){
							$responseData[$targetUrl]['facebook'] = $body -> shares;
						}
						break;
					case 'twitter':
						if(!empty($body -> count)){
							$responseData[$targetUrl]['twitter'] = $body -> count;
						}
						break;
					case 'linkedin':
						if(!empty($body -> count)){
							$responseData[$targetUrl]['linkedin'] = $body -> count;
						}
						break;
					case 'reddit':
						if(!empty($body -> data -> children)){
							$children = $body -> data -> children;
							if(!empty($children[0] -> data -> score)){
								$responseData[$targetUrl]['reddit'] = $children[0] -> data -> score;
							}
						}
						break;
					case 'delicious':
						if(!empty($body[0] -> total_posts)){
							$responseData[$targetUrl]['delicious'] = $body[0] -> total_posts;
						}
						break;
					case 'pinterest':
						if(!empty($body -> count)){
							$responseData[$targetUrl]['pinterest'] = $body -> count;
						}
						break;
					case 'stumbleupon':
						if(!empty($body -> result) && isset( $body -> result -> views )){
							$responseData[$targetUrl]['stumbleupon'] = $body -> result -> views;
						}
						break;
					case 'google':
						if(!empty($body)){
							$responseData[$targetUrl]['google'] = $body;
						}
						break;
				}
			}
		}
	}
	the_champ_ajax_response(1, $responseData);
}

add_action('wp_ajax_the_champ_sharing_count', 'the_champ_sharing_count');
add_action('wp_ajax_nopriv_the_champ_sharing_count', 'the_champ_sharing_count');

/**
 * Register LoginRadius_settings and its sanitization callback.
 */
function the_champ_sharing_meta_setup(){
	global $post;
	$postType = $post->post_type;
	$sharingMeta = get_post_meta($post->ID, '_the_champ_meta', true);
	?>
	<p>
		<label for="the_champ_sharing">
			<input type="checkbox" name="_the_champ_meta[sharing]" id="the_champ_sharing" value="1" <?php checked('1', @$sharingMeta['sharing']); ?> />
			<?php _e('Disable Horizontal Social Sharing on this '.$postType, 'Super-Socializer') ?>
		</label>
		<br/>
		<label for="the_champ_vertical_sharing">
			<input type="checkbox" name="_the_champ_meta[vertical_sharing]" id="the_champ_vertical_sharing" value="1" <?php checked('1', @$sharingMeta['vertical_sharing']); ?> />
			<?php _e('Disable Vertical Social Sharing on this '.$postType, 'Super-Socializer') ?>
		</label>
	</p>
	<?php
    echo '<input type="hidden" name="the_champ_meta_nonce" value="' . wp_create_nonce(__FILE__) . '" />';
}

/**
 * Save sharing meta fields.
 */
function the_champ_save_sharing_meta($postId){
    // make sure data came from our meta box
    if(!isset($_POST['the_champ_meta_nonce']) || !wp_verify_nonce( $_POST['the_champ_meta_nonce'], __FILE__ )){
		return $postId;
 	}
    // check user permissions
    if($_POST['post_type'] == 'page'){
        if(!current_user_can('edit_page', $postId)){
			return $postId;
    	}
	}else{
        if(!current_user_can('edit_post', $postId)){
			return $postId;
    	}
	}
    if ( isset( $_POST['_the_champ_meta'] ) ) {
		$newData = $_POST['_the_champ_meta'];
	}else{
		$newData = array( 'sharing' => 0, 'vertical_sharing' => 0 );
	}
	update_post_meta($postId, '_the_champ_meta', $newData);
    return $postId;
}