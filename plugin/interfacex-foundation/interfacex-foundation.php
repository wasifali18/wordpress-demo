<?php
/**
 * Plugin Name: InterfaceX Foundation
 * Description: A local request interface foundation for the future InterfaceX integration.
 * Version: 0.2.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined('ABSPATH') || exit;

add_shortcode('interfacex_request', static function (): string {
    wp_enqueue_script(
        'interfacex-foundation',
        plugins_url('assets/interfacex.js', __FILE__),
        [],
        '0.2.0',
        true
    );

    ob_start();
    ?>
    <div class="interface-shell">
        <div class="interface-intro">
            <p class="eyebrow">Your change workspace</p>
            <p>Describe the update you have in mind. The agent connection is not enabled yet, so nothing you enter here will be sent or saved.</p>
        </div>

        <form class="request-form" aria-describedby="request-privacy-note">
            <div class="form-field">
                <label for="interfacex-target">Choose a website</label>
                <select id="interfacex-target">
                    <option value="react-demo">React demo</option>
                    <option value="wordpress-demo">WordPress demo</option>
                </select>
            </div>
            <div class="form-field">
                <label for="interfacex-request">What would you like to change?</label>
                <textarea id="interfacex-request" rows="5" placeholder="For example: Make the homepage easier to navigate on mobile."></textarea>
            </div>
            <p class="privacy-note" id="request-privacy-note">This local demo does not transmit or store your request.</p>
            <button class="button button-primary request-submit" type="button" aria-describedby="request-privacy-note">
                Submit request
                <span aria-hidden="true">&rarr;</span>
            </button>
            <p class="request-feedback" role="status" aria-live="polite"></p>
        </form>

        <div class="workflow-panels">
            <section class="workflow-panel" aria-labelledby="workflow-status-title">
                <p class="panel-label">Workflow status</p>
                <h2 id="workflow-status-title">Not connected</h2>
                <p>Agent workflow updates will appear here when integration is available.</p>
            </section>
            <section class="workflow-panel" aria-labelledby="design-approval-title">
                <p class="panel-label">Design approval</p>
                <h2 id="design-approval-title">Not started</h2>
                <p>There is no proposal to review yet.</p>
            </section>
            <section class="workflow-panel" aria-labelledby="run-results-title">
                <p class="panel-label">Run results</p>
                <h2 id="run-results-title">No results</h2>
                <p>Verified changes and checks will be shown here in a future integration.</p>
            </section>
        </div>
    </div>
    <?php

    return (string) ob_get_clean();
});
