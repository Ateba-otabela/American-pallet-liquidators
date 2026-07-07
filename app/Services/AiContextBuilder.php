<?php

namespace App\Services;

use App\Models\ChatConversation;
use App\Models\Product;
use App\Models\Setting;

class AiContextBuilder
{
    public function buildWebsiteContext(ChatConversation $conversation, ?string $pageUrl = null, ?string $pageTitle = null): string
    {
        $email = Setting::get('contact_email', 'americanpalletliquidators0@gmail.com');
        $phone = Setting::get('contact_phone', '+44 7882 769759');

        $pageContext = '';
        if (!empty($pageTitle) || !empty($pageUrl)) {
            $pageContext = "Current visitor page: " . trim($pageTitle ?: 'Unknown title') . ". Page URL: " . trim($pageUrl ?: 'Unknown URL') . ". ";
        }

        return trim(
            "Website summary:\n" .
            $pageContext .
            $this->getContactInfo($email, $phone) .
            $this->getCatalogInfo() .
            $this->getPricingInfo() .
            $this->getShippingInfo() .
            $this->getFaqSummary() .
            "Customer email in chat: " . ($conversation->customer_email ?? 'not provided') . ".\n"
        );
    }

    protected function getContactInfo(string $email, string $phone): string
    {
        return "Contact details: " .
            "Sales/support email is " . $email . ". " .
            "Phone support is " . $phone . ". " .
            "Customers can use the contact page to request a freight quote or warehouse pickup. ";
    }

    protected function getCatalogInfo(): string
    {
        $productCount = Product::count();
        $topProducts = Product::orderBy('created_at', 'desc')->limit(5)->get(['name', 'price']);

        $summary = "The online catalog contains " . number_format($productCount) . " active listings across liquidation pallets and truckloads. ";
        if ($topProducts->count()) {
            $summary .= "Recent catalog samples: ";
            $summary .= $topProducts->map(function ($product) {
                return $product->name . " at $" . number_format($product->price, 2);
            })->implode('; ') . ". ";
        }

        return $summary;
    }

    protected function getPricingInfo(): string
    {
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        if ($minPrice !== null && $maxPrice !== null) {
            return "Price range in the catalog is approximately $" . number_format($minPrice, 2) . " to $" . number_format($maxPrice, 2) . ". " .
                "The storefront shows item prices, but freight estimates are separate. ";
        }

        return "The storefront lists individual product prices on each catalog item page. ";
    }

    protected function getShippingInfo(): string
    {
        return "Shipping details: We ship nationwide and do not bill freight at checkout. " .
            "Freight is calculated separately after the order is placed based on delivery zip code, pallet or truckload size, and carrier rates. " .
            "Warehouse pickup in Louisville, Kentucky is free of charge and forklift dock loading is provided free. ";
    }

    protected function getFaqSummary(): string
    {
        return "FAQ highlights: Prices are low because inventory is bought in liquidation volume and sold AS-IS / WHERE-IS. " .
            "All sales are final with no returns, refunds, or exchanges. " .
            "Customers can inspect inventory in person at the warehouse. " .
            "For questions about shipping, payment methods, or inventory condition, explain the policies clearly and offer to connect customers with a support specialist when a custom quote or exact freight total is needed. ";
    }
}
