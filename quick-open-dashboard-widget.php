<?php
/**
 * Plugin Name: Quick Open Dashboard Widget
 * Plugin URI: https://github.com/UniversalYumsLLC/quick-open-dashboard-widget
 * Description: Dashboard widget to quickly open orders in WooCommerce.
 * Version: 1.0.0
 * Author: Universal Yums
 * Author URI: https://universalyums.com
 * Developer: Devin Price
 * Developer URI: https://github.com/devinsays
 *
 * WC requires at least: 5.6.0
 * WC tested up to: 5.8.0
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */


/**
 * Class QuickOpenDashboardWidget
 * @package QuickOpenDashboardWidget
 */
class QuickOpenDashboardWidget {

	/**
	 * The single instance of the class.
	 *
	 * @var mixed $instance
	 */
	protected static $instance;

	/**
	 * Main QuickOpenDashboardWidget Instance.
	 *
	 * Ensures only one instance of the QuickOpenDashboardWidget is loaded or can be loaded.
	 *
	 * @return QuickOpenDashboardWidget - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', [ $this, 'add_widgets' ], 100 );
	}

	public function add_widgets() {
		if ( current_user_can( 'edit_posts' ) ) {
			$title = __( 'WooCommerce Quick Open', 'quick-open' );
			wp_add_dashboard_widget( 'quick_open', $title, [ $this, 'quick_open_widget' ] );
		}
	}

	/**
	 * Widget outputs a form to open a post by post ID.
	 */
	public function quick_open_widget() {
		$label = __( 'Enter the ID of an order, product or post to open.', 'quick-open' );
		$button = __( 'Open &rarr;', 'quick-open' );
		?>
			<form method="GET" action="<?php echo admin_url( 'post.php' ); ?>">
				<p style="margin: 0 0 1em">
					<label for="post"><?php esc_html_e( $label ); ?></label>
				</p>
				<input type="number" id="post" name="post" placeholder="12345"/>
				<?php submit_button( esc_html( $button ) , 'primary', '', false ); ?>
				<input type="hidden" name="action" value="edit"/>
			</form>
		<?php
	}
}

QuickOpenDashboardWidget::instance();
