<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            // Cryptomonnaies
            [
                'name' => 'Bitcoin (BTC)',
                'slug' => 'bitcoin',
                'type' => 'crypto',
                'description' => 'Paiement via Bitcoin',
                'config' => [
                    'wallet_address' => 'bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh',
                    'network' => 'BTC',
                    'min_confirmations' => 3,
                ],
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Ethereum (ETH)',
                'slug' => 'ethereum',
                'type' => 'crypto',
                'description' => 'Paiement via Ethereum',
                'config' => [
                    'wallet_address' => '0x742d35Cc6634C0532925a3b844Bc9e7595f0bEb',
                    'network' => 'ERC20',
                    'min_confirmations' => 12,
                ],
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'USDT (TRC20)',
                'slug' => 'usdt-trc20',
                'type' => 'crypto',
                'description' => 'Tether sur réseau TRON',
                'config' => [
                    'wallet_address' => 'TRX9QsuLk1hoBAgmcvxK6wVPvtCpVf3EUr',
                    'network' => 'TRC20',
                    'min_confirmations' => 20,
                ],
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Binance Coin (BNB)',
                'slug' => 'bnb',
                'type' => 'crypto',
                'description' => 'Paiement via BNB',
                'config' => [
                    'wallet_address' => 'bnb1grpf0955h0ykzq3ar5nmum7y6gdfl6lxfn46h2',
                    'network' => 'BSC',
                    'min_confirmations' => 15,
                ],
                'is_active' => true,
                'order' => 4,
            ],

            // E-Wallets
            [
                'name' => 'Perfect Money',
                'slug' => 'perfect-money',
                'type' => 'e-wallet',
                'description' => 'Paiement via Perfect Money',
                'config' => [
                    'account_id' => 'U12345678',
                    'passphrase' => env('PERFECT_MONEY_PASSPHRASE'),
                ],
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Payeer',
                'slug' => 'payeer',
                'type' => 'e-wallet',
                'description' => 'Paiement via Payeer',
                'config' => [
                    'account_id' => 'P123456789',
                    'api_id' => env('PAYEER_API_ID'),
                    'api_key' => env('PAYEER_API_KEY'),
                ],
                'is_active' => true,
                'order' => 6,
            ],

            // Mobile Money
            [
                'name' => 'Mobile Money (MTN)',
                'slug' => 'mtn-mobile-money',
                'type' => 'mobile-money',
                'description' => 'Paiement via MTN Mobile Money',
                'config' => [
                    'phone_number' => '+229XXXXXXXX',
                    'operator' => 'MTN',
                ],
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Mobile Money (Moov)',
                'slug' => 'moov-mobile-money',
                'type' => 'mobile-money',
                'description' => 'Paiement via Moov Money',
                'config' => [
                    'phone_number' => '+229XXXXXXXX',
                    'operator' => 'MOOV',
                ],
                'is_active' => true,
                'order' => 8,
            ],

            // Cartes bancaires
            [
                'name' => 'Visa / Mastercard',
                'slug' => 'card',
                'type' => 'bank-card',
                'description' => 'Paiement par carte bancaire',
                'config' => [
                    'processor' => 'stripe',
                    'api_key' => env('STRIPE_KEY'),
                ],
                'is_active' => false, // Désactivé par défaut (nécessite configuration Stripe)
                'order' => 9,
            ],

            // Virement bancaire
            [
                'name' => 'Virement Bancaire',
                'slug' => 'bank-transfer',
                'type' => 'bank-transfer',
                'description' => 'Virement bancaire direct',
                'config' => [
                    'bank_name' => 'Bank of Africa',
                    'account_number' => 'BJ064XXXXXXXXXX',
                    'iban' => 'BJXXXXXXXXXXXXXXXXXX',
                    'swift' => 'AFRIBJBJ',
                ],
                'is_active' => true,
                'order' => 10,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }

        $this->command->info('Payment Methods created successfully!');
    }
}