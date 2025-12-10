<?php
/**
 * The front page template file
 *
 * @package KR_Theme
 * @since 1.3.3
 */

get_header();
?>

<!-- Hero Section -->
<section style="
	background: linear-gradient(135deg, rgba(102,126,234,0.95), rgba(168,85,247,0.95)), 
				url('https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&h=1080&fit=crop&q=80');
	background-size: cover;
	background-position: center;
	min-height: 60vh;
	display: flex;
	align-items: center;
	justify-content: center;
	text-align: center;
	padding: 4rem 2rem;
">
	<div class="container">
		<h1 style="
			font-size: clamp(2.5rem, 6vw, 4rem);
			margin-bottom: 1rem;
			color: #ffffff;
			font-weight: 800;
			letter-spacing: -0.02em;
		">
			Build Amazing Websites
		</h1>
		<p style="
			font-size: 1.25rem;
			margin-bottom: 2rem;
			color: rgba(255,255,255,0.95);
			max-width: 600px;
			margin-left: auto;
			margin-right: auto;
			line-height: 1.6;
		">
			Fast, modern, and beautifully designed WordPress theme
		</p>
		<a href="#features" style="
			display: inline-block;
			background: #ffffff;
			color: #667eea;
			padding: 0.875rem 2rem;
			font-size: 1rem;
			font-weight: 600;
			border-radius: 50px;
			text-decoration: none;
			transition: all 0.3s ease;
		">
			Get Started
		</a>
	</div>
</section>

<!-- Features Section -->
<section id="features" style="padding: 4rem 0; background: #ffffff;">
	<div class="container">
		<h2 style="text-align: center; margin-bottom: 3rem; font-size: clamp(2rem, 4vw, 2.5rem); color: #1e293b;">
			Why Choose KR Theme
		</h2>
		
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
			<div style="text-align: center; padding: 1.5rem;">
				<div style="
					width: 64px;
					height: 64px;
					margin: 0 auto 1rem;
					border-radius: 12px;
					background: linear-gradient(135deg, #667eea, #a855f7);
					display: flex;
					align-items: center;
					justify-content: center;
					font-size: 1.75rem;
				">⚡</div>
				<h3 style="margin-bottom: 0.75rem; font-size: 1.25rem; color: #1e293b;">Ultra Fast</h3>
				<p style="color: #64748b; line-height: 1.6; margin: 0;">Optimized for speed and performance</p>
			</div>

			<div style="text-align: center; padding: 1.5rem;">
				<div style="
					width: 64px;
					height: 64px;
					margin: 0 auto 1rem;
					border-radius: 12px;
					background: linear-gradient(135deg, #667eea, #a855f7);
					display: flex;
					align-items: center;
					justify-content: center;
					font-size: 1.75rem;
				">🎨</div>
				<h3 style="margin-bottom: 0.75rem; font-size: 1.25rem; color: #1e293b;">Beautiful Design</h3>
				<p style="color: #64748b; line-height: 1.6; margin: 0;">Clean and modern interface</p>
			</div>

			<div style="text-align: center; padding: 1.5rem;">
				<div style="
					width: 64px;
					height: 64px;
					margin: 0 auto 1rem;
					border-radius: 12px;
					background: linear-gradient(135deg, #667eea, #a855f7);
					display: flex;
					align-items: center;
					justify-content: center;
					font-size: 1.75rem;
				">📱</div>
				<h3 style="margin-bottom: 0.75rem; font-size: 1.25rem; color: #1e293b;">Responsive</h3>
				<p style="color: #64748b; line-height: 1.6; margin: 0;">Works perfectly on all devices</p>
			</div>
		</div>
	</div>
</section>

<!-- Stats Section -->
<section style="padding: 4rem 0; background: linear-gradient(135deg, rgba(102,126,234,0.05), rgba(168,85,247,0.05));">
	<div class="container">
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
			<div>
				<div style="font-size: 3rem; font-weight: 800; color: #667eea; margin-bottom: 0.5rem;">100+</div>
				<p style="color: #64748b; margin: 0;">Active Users</p>
			</div>
			<div>
				<div style="font-size: 3rem; font-weight: 800; color: #667eea; margin-bottom: 0.5rem;">5★</div>
				<p style="color: #64748b; margin: 0;">User Rating</p>
			</div>
			<div>
				<div style="font-size: 3rem; font-weight: 800; color: #667eea; margin-bottom: 0.5rem;">24/7</div>
				<p style="color: #64748b; margin: 0;">Support</p>
			</div>
		</div>
	</div>
</section>

<!-- Content Section -->
<section style="padding: 4rem 0; background: #ffffff;">
	<div class="container">
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; align-items: center;">
			<div>
				<h2 style="margin-bottom: 1.5rem; font-size: clamp(1.75rem, 3vw, 2.25rem); color: #1e293b;">
					Powerful Features
				</h2>
				<p style="color: #64748b; line-height: 1.7; margin-bottom: 1.5rem;">
					Built with modern web standards and best practices. Includes Elementor compatibility, WooCommerce support, and extensive customization options.
				</p>
				<ul style="list-style: none; padding: 0; margin: 0;">
					<li style="padding: 0.5rem 0; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
						<span style="color: #10b981; font-weight: bold;">✓</span> SEO Optimized
					</li>
					<li style="padding: 0.5rem 0; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
						<span style="color: #10b981; font-weight: bold;">✓</span> Accessibility Ready
					</li>
					<li style="padding: 0.5rem 0; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
						<span style="color: #10b981; font-weight: bold;">✓</span> Translation Ready
					</li>
				</ul>
			</div>
			<div style="border-radius: 12px; overflow: hidden;">
				<img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop&q=80" 
					 alt="Features" 
					 style="width: 100%; height: auto; display: block;">
			</div>
		</div>
	</div>
</section>

<!-- Testimonial Section -->
<section style="padding: 4rem 0; background: #f8fafc;">
	<div class="container" style="max-width: 800px; text-align: center;">
		<div style="
			background: #ffffff;
			padding: 2.5rem;
			border-radius: 12px;
			border: 1px solid #e2e8f0;
		">
			<p style="
				font-size: 1.25rem;
				color: #1e293b;
				line-height: 1.7;
				margin-bottom: 1.5rem;
				font-style: italic;
			">
				"KR Theme transformed our website. It's fast, beautiful, and easy to customize. Highly recommended!"
			</p>
			<div style="
				width: 48px;
				height: 48px;
				border-radius: 50%;
				background: linear-gradient(135deg, #667eea, #a855f7);
				margin: 0 auto 0.75rem;
			"></div>
			<p style="font-weight: 600; color: #1e293b; margin: 0;">Sarah Johnson</p>
			<p style="color: #64748b; font-size: 0.875rem; margin: 0;">Web Designer</p>
		</div>
	</div>
</section>

<!-- Latest Posts -->
<section style="padding: 4rem 0; background: #ffffff;">
	<div class="container">
		<h2 style="text-align: center; margin-bottom: 3rem; font-size: clamp(2rem, 4vw, 2.5rem); color: #1e293b;">
			Recent Articles
		</h2>
		
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
			<?php
			$latest_posts = new WP_Query(array(
				'posts_per_page' => 3,
				'post_status' => 'publish'
			));
			
			if ($latest_posts->have_posts()) :
				while ($latest_posts->have_posts()) : $latest_posts->the_post();
			?>
				<article style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
					<?php if (has_post_thumbnail()) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 200px; object-fit: cover; display: block;')); ?>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>">
							<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=600&h=400&fit=crop&q=80" 
								 alt="<?php the_title_attribute(); ?>"
								 style="width: 100%; height: 200px; object-fit: cover; display: block;">
						</a>
					<?php endif; ?>
					<div style="padding: 1.5rem;">
						<h3 style="margin-bottom: 0.75rem; font-size: 1.25rem; color: #1e293b;">
							<a href="<?php the_permalink(); ?>" style="color: #1e293b; text-decoration: none;">
								<?php the_title(); ?>
							</a>
						</h3>
						<p style="color: #64748b; line-height: 1.6; margin: 0;">
							<?php echo wp_trim_words(get_the_excerpt(), 15); ?>
						</p>
					</div>
				</article>
			<?php
				endwhile;
				wp_reset_postdata();
			else :
			?>
				<div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
					<p style="color: #64748b; font-size: 1.125rem;">No posts yet. Create your first post to get started!</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- CTA Section -->
<section style="
	padding: 4rem 2rem;
	background: linear-gradient(135deg, #667eea, #a855f7);
	text-align: center;
">
	<div class="container" style="max-width: 700px;">
		<h2 style="margin-bottom: 1rem; font-size: clamp(1.75rem, 4vw, 2.25rem); color: #ffffff;">
			Ready to Get Started?
		</h2>
		<p style="
			font-size: 1.125rem;
			color: rgba(255,255,255,0.95);
			margin-bottom: 2rem;
			line-height: 1.6;
		">
			Experience the power of a modern, lightweight WordPress theme
		</p>
		<a href="<?php echo esc_url(admin_url('customize.php')); ?>" style="
			display: inline-block;
			background: #ffffff;
			color: #667eea;
			padding: 0.875rem 2rem;
			font-size: 1rem;
			font-weight: 600;
			border-radius: 50px;
			text-decoration: none;
		">
			Customize Now
		</a>
	</div>
</section>

<?php
get_footer();
