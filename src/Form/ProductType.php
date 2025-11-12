<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * Get category choices (Name => ID)
     * @return array<string, int>
     */
    private static function getCategoryChoices(): array
    {
        return [
            "Antiques" => 20081,
            "Art" => 550,
            "Baby" => 2984,
            "Books and Magazines" => 267,
            "Business and Industrial" => 12576,
            "Cameras and Photo" => 625,
            "Cell Phones and Accessories" => 15032,
            "Clothing, Shoes and Accessories" => 11450,
            "Coins and Paper Money" => 11116,
            "Collectibles" => 1,
            "Computers, Tablets and Networking" => 58058,
            "Consumer Electronics" => 293,
            "Crafts" => 14339,
            "Dolls and Bears" => 237,
            "Movies and TV" => 11232,
            "Entertainment Memorabilia" => 45100,
            "Gift Cards and Coupons" => 172008,
            "Health and Beauty" => 26395,
            "Home and Garden" => 11700,
            "Jewelry and Watches" => 281,
            "Music" => 11233,
            "Musical Instruments and Gear" => 619,
            "Pet Supplies" => 1281,
            "Pottery and Glass" => 870,
            "Real Estate" => 10542,
            "Specialty Services" => 316,
            "Sporting Goods" => 888,
            "Sports Memorabilia, Cards and Fan Shop" => 64482,
            "Stamps" => 260,
            "Tickets and Experiences" => 1305,
            "Toys and Hobbies" => 220,
            "Travel" => 3252,
            "Video Games and Consoles" => 1249,
            "Everything Else" => 99,
            "eBay Motors" => 6000,
        ];
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $builder
            ->add("name", TextType::class)
            ->add("price", MoneyType::class, [
                "currency" => false,
                "divisor" => 100,
            ])
            ->add("minimum_price", MoneyType::class, [
                "currency" => false,
                "divisor" => 100,
            ])
            ->add("description", TextareaType::class, [
                "attr" => ["rows" => 3],
            ])
            ->add("category", ChoiceType::class, [
                "label" => "Category",
                "choices" => self::getCategoryChoices(),
                "required" => false,
                "placeholder" => "All Categories",
            ])
            ->add("save", SubmitType::class, ["label" => "Save product"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Product::class,
        ]);
    }

    /**
     * Get categories mapping (ID => Name)
     * @return array<int, string>
     */
    public static function getCategories(): array
    {
        // Flip array to get ID => Name mapping
        return array_flip(self::getCategoryChoices());
    }
}
