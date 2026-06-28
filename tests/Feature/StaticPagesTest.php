<?php

namespace Tests\Feature;

use Tests\TestCase;

class StaticPagesTest extends TestCase
{
    /**
     * Test Tentang Kami page.
     */
    public function test_about_page_is_accessible(): void
    {
        $response = $this->get('/tentang-kami');
        $response->assertStatus(200);
        $response->assertSee('Tentang');
    }

    /**
     * Test Cara Pembelian page.
     */
    public function test_how_to_buy_page_is_accessible(): void
    {
        $response = $this->get('/cara-pembelian');
        $response->assertStatus(200);
        $response->assertSee('Pembelian');
    }

    /**
     * Test Konsultasi Ukuran page.
     */
    public function test_size_guide_page_is_accessible(): void
    {
        $response = $this->get('/konsultasi-ukuran');
        $response->assertStatus(200);
        $response->assertSee('Ukuran');
    }

    /**
     * Test Kebijakan Privasi page.
     */
    public function test_privacy_policy_page_is_accessible(): void
    {
        $response = $this->get('/kebijakan-privasi');
        $response->assertStatus(200);
        $response->assertSee('Privasi');
    }

    /**
     * Test Syarat & Ketentuan page.
     */
    public function test_terms_page_is_accessible(): void
    {
        $response = $this->get('/syarat-ketentuan');
        $response->assertStatus(200);
        $response->assertSee('Syarat');
    }
}
