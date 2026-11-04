<?php get_header(); ?>
<main class="site-main landing-page">
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-copy">
            <p class="eyebrow">A calmer way to redesign</p>
            <h1 id="hero-title">Make your next website change with confidence.</h1>
            <p class="hero-description">
                Describe what you want to improve. Review a clear proposal. Then verify
                the result before it goes anywhere.
            </p>
            <a class="button button-primary" href="<?php echo esc_url(home_url('/interfacex/')); ?>">
                Start a redesign request
                <span aria-hidden="true">&rarr;</span>
            </a>
            <p class="hero-note">A guided workflow for thoughtful website updates.</p>
        </div>
        <div class="hero-visual" aria-hidden="true">
            <div class="preview-window">
                <div class="preview-toolbar">
                    <span></span><span></span><span></span>
                    <span class="preview-address">your-website.com</span>
                </div>
                <div class="preview-content">
                    <div class="preview-nav"><span></span><span></span></div>
                    <div class="preview-heading"></div>
                    <div class="preview-line"></div>
                    <div class="preview-line preview-line-short"></div>
                    <div class="preview-action"></div>
                    <div class="preview-cards"><span></span><span></span><span></span></div>
                </div>
                <div class="preview-badge"><span aria-hidden="true">&#10003;</span> Ready to review</div>
            </div>
            <div class="hero-orbit hero-orbit-one"></div>
            <div class="hero-orbit hero-orbit-two"></div>
        </div>
    </section>

    <section class="how-it-works" aria-labelledby="steps-title">
        <div class="section-heading">
            <p class="eyebrow">From idea to verified change</p>
            <h2 id="steps-title">Three steps. You stay in control.</h2>
        </div>
        <ol class="steps-list">
            <li class="step-card">
                <span class="step-number" aria-hidden="true">01</span>
                <h3>Describe the change</h3>
                <p>Tell us what you would like to improve and choose the website to work on.</p>
            </li>
            <li class="step-card">
                <span class="step-number" aria-hidden="true">02</span>
                <h3>Review the proposal</h3>
                <p>See the suggested direction and decide whether it is right before work begins.</p>
            </li>
            <li class="step-card">
                <span class="step-number" aria-hidden="true">03</span>
                <h3>Verify the result</h3>
                <p>Check the finished change and its results before choosing what happens next.</p>
            </li>
        </ol>
    </section>

    <section class="closing-cta" aria-labelledby="closing-title">
        <div>
            <p class="eyebrow">Your next idea starts here</p>
            <h2 id="closing-title">Ready to explore a change?</h2>
        </div>
        <a class="button button-light" href="<?php echo esc_url(home_url('/interfacex/')); ?>">
            Go to InterfaceX
            <span aria-hidden="true">&rarr;</span>
        </a>
    </section>
</main>
<?php get_footer(); ?>
