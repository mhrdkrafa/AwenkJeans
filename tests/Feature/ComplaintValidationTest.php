<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Size;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ComplaintValidationTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $transaction;
    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed Roles
        $pelangganRole = Role::create(['name' => 'pelanggan']);
        $karyawanRole = Role::create(['name' => 'karyawan']);

        // Create User
        $this->user = User::create([
            'name' => 'Test Pelanggan',
            'email' => 'pelanggan@test.com',
            'password' => bcrypt('password'),
            'role_id' => $pelangganRole->id,
            'phone' => '081234567890',
        ]);

        // Create Category & Size
        $category = Category::create(['name' => 'Jeans', 'slug' => 'jeans']);
        $size = Size::create(['name' => '32']);

        // Create Product
        $this->product = Product::create([
            'name' => 'Awenk Slim Fit Blue',
            'slug' => 'awenk-slim-fit-blue',
            'price' => 150000,
            'stock' => 10,
            'category_id' => $category->id,
            'size_id' => $size->id,
        ]);

        // Create Transaction (recent, within 3 days)
        $this->transaction = Transaction::create([
            'invoice_number' => 'INV-20260626-0001',
            'pelanggan_id' => $this->user->id,
            'customer_name' => $this->user->name,
            'customer_phone' => $this->user->phone,
            'total_price' => 150000,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
        ]);

        // Create Transaction Detail
        TransactionDetail::create([
            'transaction_id' => $this->transaction->id,
            'product_id' => $this->product->id,
            'quantity' => 1,
            'price' => 150000,
            'subtotal' => 150000,
        ]);
    }

    public function test_complaint_requires_attachments(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/pelanggan/complaints', [
                'transaction_id' => $this->transaction->id,
                'product_id' => $this->product->id,
                'subject' => 'Barang Rusak',
                'message' => 'Detail kerusakan pada kancing celana.',
            ]);

        $response->assertSessionHasErrors('attachments');
        $this->assertDatabaseCount('complaints', 0);
    }

    public function test_complaint_creation_succeeds_with_attachments(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg');

        $response = $this
            ->actingAs($this->user)
            ->post('/pelanggan/complaints', [
                'transaction_id' => $this->transaction->id,
                'product_id' => $this->product->id,
                'subject' => 'Barang Rusak',
                'message' => 'Detail kerusakan pada kancing celana.',
                'attachments' => [$file],
            ]);

        $response->assertRedirect('/pelanggan/complaints');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('complaints', [
            'user_id' => $this->user->id,
            'transaction_id' => $this->transaction->id,
            'product_id' => $this->product->id,
            'subject' => 'Barang Rusak',
            'message' => 'Detail kerusakan pada kancing celana.',
        ]);

        $complaint = Complaint::first();
        $this->assertNotNull($complaint->attachments);
        $this->assertCount(1, $complaint->attachments);

        // Verify stored file
        Storage::disk('public')->assertExists($complaint->attachments[0]);
    }
}
