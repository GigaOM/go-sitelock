<?php

class GO_SiteLock
{
	protected $caps_to_disable = array(
		'activate_plugins',
		'comment',
		'companies',
		'create_users',
		'delete_others_pages',
		'delete_others_posts',
		'delete_pages',
		'delete_posts',
		'delete_private_pages',
		'delete_private_posts',
		'delete_published_pages',
		'delete_published_posts',
		'delete_users',
		'edit_engagements',
		'edit_files',
		'edit_messages',
		'edit_others_pages',
		'edit_others_posts',
		'edit_pages',
		'edit_plugins',
		'edit_posts',
		'edit_private_pages',
		'edit_private_posts',
		'edit_profile',
		'edit_published_pages',
		'edit_published_posts',
		'edit_settings',
		'edit_themes',
		'edit_users',
		'import',
		'manage_categories',
		'manage_links',
		'manage_options',
		'moderate_comments',
		'post_comment',
		'publish_pages',
		'publish_posts',
		'switch_themes',
		'upload_files',
	);

	/**
	 * constructor, sets up filters
	 */
	public function __construct()
	{
		add_filter( 'comments_open', array( $this, 'comments_open' ), 99 );
		add_filter( 'user_has_cap', array( $this, 'user_has_cap' ), 99 );

		add_filter( 'go_site_locked', array( $this, 'go_site_locked' ) );
	}// end __construct

	/**
	 * hooked to the 'comments_open' filter, closes comments for all posts
	 */
	public function comments_open( $open )
	{
		return FALSE;
	}//end comments_open

	/**
	 * hooked to the 'go_site_locked' filter to provide a conditional to lock a given page
	 */
	public function go_site_locked( $locked )
	{
		return TRUE;
	}//end go_site_locked

	/**
	 * filter user_has_cap to remove any edit/update related caps
	 *
	 * @param $allcaps array of capabilities they have (to be filtered)
	 */
	public function user_has_cap( $allcaps )
	{
		$allcaps = array_diff_key( $allcaps, array_fill_keys( $this->caps_to_disable, null ) );

		return $allcaps;
	}//end user_has_cap

	/**
	 * a message to show in cases where a page is not rendering because we have locked it
	 *
	 * @param $message string to be inserted in a sentence like: $message is current disabled...
	 */
	public function lock_screen( $message )
	{
		?>
		<h3>Bonk!</h3>
		<p class="go-lock-message">
			<?php echo $message; ?> is currently disabled as we upgrade our system. Don't worry, this won't take too long and everything will be spiffy and new in a jiffy! Please visit <a href='http://twitter.com/gigaomresearch'>http://twitter.com/gigaomresearch</a> for the latest updates.
		</p>
		<?php
	}//end lock_screen
}// end class

/**
 * Singleton
 */
function go_sitelock()
{
	global $go_sitelock;

	if ( ! $go_sitelock )
	{
		$go_sitelock = new GO_SiteLock;
	}//end if

	return $go_sitelock;
}//end go_sitelock
