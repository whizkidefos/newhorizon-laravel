<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Home page content
        SiteSetting::create([
            'key' => 'home_hero_title',
            'value' => 'Healthcare Professionals You Can Trust',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'Home Hero Title',
            'description' => 'Main title displayed on the home page hero section',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'home_hero_subtitle',
            'value' => 'Providing quality healthcare services across the UK',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'Home Hero Subtitle',
            'description' => 'Subtitle displayed on the home page hero section',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'home_about_text',
            'value' => 'New Horizon Healthcare Services is dedicated to providing exceptional healthcare services with a focus on quality, compassion, and professionalism.',
            'type' => 'textarea',
            'group' => 'page_content',
            'label' => 'Home About Text',
            'description' => 'Text displayed in the about section of the home page',
            'is_public' => true,
        ]);

        // About page content
        SiteSetting::create([
            'key' => 'about_title',
            'value' => 'About New Horizon Healthcare Services',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'About Page Title',
            'description' => 'Title displayed on the about page',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'about_content',
            'value' => 'New Horizon Healthcare Services was founded with a mission to provide high-quality healthcare staffing solutions across the UK. Our team of dedicated professionals brings years of experience in healthcare delivery and management.',
            'type' => 'textarea',
            'group' => 'page_content',
            'label' => 'About Page Content',
            'description' => 'Main content displayed on the about page',
            'is_public' => true,
        ]);

        // Contact page content
        SiteSetting::create([
            'key' => 'contact_title',
            'value' => 'Contact Us',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'Contact Page Title',
            'description' => 'Title displayed on the contact page',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'contact_address',
            'value' => '123 Healthcare Avenue, London, UK, W1 1AA',
            'type' => 'textarea',
            'group' => 'page_content',
            'label' => 'Office Address',
            'description' => 'Office address displayed on the contact page',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'contact_email',
            'value' => 'info@newhorizonhealthcare.co.uk',
            'type' => 'email',
            'group' => 'page_content',
            'label' => 'Contact Email',
            'description' => 'Email address displayed on the contact page',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'contact_phone',
            'value' => '+44 20 1234 5678',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'Contact Phone',
            'description' => 'Phone number displayed on the contact page',
            'is_public' => true,
        ]);

        // Footer content
        SiteSetting::create([
            'key' => 'footer_copyright',
            'value' => '© 2025 New Horizon Healthcare Services. All rights reserved.',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'Footer Copyright',
            'description' => 'Copyright text displayed in the footer',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'footer_tagline',
            'value' => 'Dedicated to healthcare excellence',
            'type' => 'text',
            'group' => 'page_content',
            'label' => 'Footer Tagline',
            'description' => 'Tagline displayed in the footer',
            'is_public' => true,
        ]);

        // SEO settings
        SiteSetting::create([
            'key' => 'site_title',
            'value' => 'New Horizon Healthcare Services',
            'type' => 'text',
            'group' => 'seo',
            'label' => 'Site Title',
            'description' => 'Title used for SEO and browser tab',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'site_description',
            'value' => 'New Horizon Healthcare Services provides quality healthcare staffing solutions across the UK.',
            'type' => 'textarea',
            'group' => 'seo',
            'label' => 'Site Description',
            'description' => 'Meta description used for SEO',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'site_keywords',
            'value' => 'healthcare, staffing, nurses, caregivers, UK healthcare',
            'type' => 'text',
            'group' => 'seo',
            'label' => 'Site Keywords',
            'description' => 'Meta keywords used for SEO',
            'is_public' => true,
        ]);

        // Logo and favicon settings (these will be empty until uploaded)
        SiteSetting::create([
            'key' => 'site_logo',
            'value' => '',
            'type' => 'file',
            'group' => 'appearance',
            'label' => 'Site Logo',
            'description' => 'Main logo displayed in the header',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'site_logo_alt',
            'value' => 'New Horizon Healthcare Services',
            'type' => 'text',
            'group' => 'appearance',
            'label' => 'Logo Alt Text',
            'description' => 'Alternative text for the logo image',
            'is_public' => true,
        ]);

        SiteSetting::create([
            'key' => 'site_favicon',
            'value' => '',
            'type' => 'file',
            'group' => 'appearance',
            'label' => 'Site Favicon',
            'description' => 'Favicon displayed in browser tabs',
            'is_public' => true,
        ]);
    }
}
