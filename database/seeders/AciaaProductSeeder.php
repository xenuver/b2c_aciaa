<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AciaaProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() == 0 && Product::count() == 0) {
            // Define the 4 core categories requested by the user
            $categoriesData = [
                [
                    'id' => 1,
                    'name' => 'Atasan',
                    'slug' => 'atasan',
                    'description' => 'Blouse, kemeja, crop top, dan knitwear wanita import premium',
                    'icon' => 'fa-tshirt',
                    'order' => 1,
                    'is_active' => 1,
                ],
                [
                    'id' => 2,
                    'name' => 'Bawahan',
                    'slug' => 'bawahan',
                    'description' => 'Celana panjang, wide-leg trousers, kulot, dan rok kasual elegan',
                    'icon' => 'fa-shopping-bag',
                    'order' => 2,
                    'is_active' => 1,
                ],
                [
                    'id' => 3,
                    'name' => 'Dress',
                    'slug' => 'dress',
                    'description' => 'Midi dress, floral dress, satin slip dress, dan abaya premium',
                    'icon' => 'fa-female',
                    'order' => 3,
                    'is_active' => 1,
                ],
                [
                    'id' => 4,
                    'name' => 'Outer',
                    'slug' => 'outer',
                    'description' => 'Knitted cardigan, blazer formal, dan jaket kasual modern',
                    'icon' => 'fa-vest',
                    'order' => 4,
                    'is_active' => 1,
                ]
            ];

            foreach ($categoriesData as $cat) {
                Category::create($cat);
            }

        // Define 50 beautifully curated products distributed across the 4 core categories
        $productsData = [
            // ========== ATASAN (ID 1) - 13 Products ==========
            [
                'category_id' => 1,
                'name' => 'Rosie Satin Silk Blouse',
                'description' => 'Blouse wanita premium berbahan sutra satin halus berkualitas tinggi. Memiliki kilau mewah yang elegan dengan potongan loose-fit, sangat nyaman untuk ke kantor maupun acara formal lainnya. Barang original import dengan detail jahitan yang sangat rapi.',
                'price' => 189000,
                'image' => 'products/atasan_1.png',
                'sku' => 'AC-TOP-001',
            ],
            [
                'category_id' => 1,
                'name' => 'Kore Soft Linen Crop Shirt',
                'description' => 'Kemeja crop berbahan linen katun premium bernapas gaya Korea modern. Sangat sejuk dan bertekstur kasual mewah, berkerah rapi dengan kancing resin natural. Sempurna dipadukan dengan celana high-waist.',
                'price' => 169000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-TOP-002',
            ],
            [
                'category_id' => 1,
                'name' => 'Mochi Knitted Oversized Top',
                'description' => 'Atasan rajut oversized premium dengan tekstur ribbed murni yang super halus. Terasa sangat elastis, ringan namun menghangatkan. Menampilkan potongan leher bulat klasik yang minimalis dan aesthetic.',
                'price' => 219000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-TOP-003',
            ],
            [
                'category_id' => 1,
                'name' => 'Luna Pleated Flowy Blouse',
                'description' => 'Blouse dengan detail lipatan (pleated) mikro dan kerah model ruffle melingkar yang menawan. Berbahan premium polyester crepe yang jatuh dan tidak mudah kusut. Pilihan anggun untuk tampilan formal feminin.',
                'price' => 199000,
                'image' => 'products/atasan_1.png',
                'sku' => 'AC-TOP-004',
            ],
            [
                'category_id' => 1,
                'name' => 'Daisy Vintage Floral Top',
                'description' => 'Atasan bergaya retro vintage dengan potongan kerah persegi (square neck) yang menampilkan siluet leher yang jenjang. Dihiasi motif bunga daisy kecil bernuansa pastel lembut di atas bahan katun sejuk fungsional.',
                'price' => 179000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-TOP-005',
            ],
            [
                'category_id' => 1,
                'name' => 'Selena Drapey Wrap Top',
                'description' => 'Atasan model lilit draping satin silk impor bertekstur mewah yang berkilau lembut. Dilengkapi dengan tali samping ikat serbaguna yang bisa disesuaikan dengan lekuk tubuh untuk menonjolkan keanggunan wanita modern.',
                'price' => 249000,
                'image' => 'products/atasan_1.png',
                'sku' => 'AC-TOP-006',
            ],
            [
                'category_id' => 1,
                'name' => 'Haru Casual Ribbed Tee',
                'description' => 'Kaos rajut ribbed premium berbahan katun elastis bernapas. Berpotongan slim-fit dengan kerah bulat minimalis, sangat pas digunakan sebagai baju dasar (layering) atau atasan kasual sehari-hari.',
                'price' => 159000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-TOP-007',
            ],
            [
                'category_id' => 1,
                'name' => 'Chiffon Lily Puff Blouse',
                'description' => 'Blouse lengan balon (puff sleeve) berbahan chiffon premium dengan motif bunga lily lembut. Dilengkapi furing bagian dalam katun sejuk anti-tembus pandang dan ujung lengan karet elastis yang wudhu-friendly.',
                'price' => 229000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-TOP-008',
            ],
            [
                'category_id' => 1,
                'name' => 'Tokyo Asymmetric Collar Shirt',
                'description' => 'Kemeja berkerah asimetris modern khas mode busana jalanan Tokyo. Memiliki potongan garis kancing menyamping yang sangat chic dan unik, berbahan premium katun drill tipis halus yang kokoh.',
                'price' => 259000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-TOP-009',
            ],
            [
                'category_id' => 1,
                'name' => 'Sienna Linen Summer Blouse',
                'description' => 'Blouse kasual santai berbahan katun linen bernapas dengan detail kancing kayu alami di bagian depan. Memiliki tekstur khas rami yang premium dan sejuk dipakai saat cuaca panas.',
                'price' => 179000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-TOP-010',
            ],
            [
                'category_id' => 1,
                'name' => 'Inaya Buttoned Linen Tunik',
                'description' => 'Tunik kemeja panjang berkerah tegak klasik berbahan 100% linen rami premium impor. Memiliki kancing aktif baris penuh di bagian depan dan belahan samping bawah untuk keleluasaan bergerak.',
                'price' => 219000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-TOP-011',
            ],
            [
                'category_id' => 1,
                'name' => 'Mariam Tiered Tunik Blouse',
                'description' => 'Tunik blouse panjang berundak tiga bersiluet loose yang longgar dan anggun menutup pinggul. Terbuat dari katun viscose impor premium super halus yang sejuk alami dan ramah kulit.',
                'price' => 229000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-TOP-012',
            ],
            [
                'category_id' => 1,
                'name' => 'Mila Ribbed Active Sport Top',
                'description' => 'Atasan baju olahraga wanita premium berbahan nilon spandeks ribbed rajut melar 4-arah. Sangat elastis, cepat kering, dan menunjang mobilitas tinggi dengan desain contemporary yang sporty chic.',
                'price' => 189000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-TOP-013',
            ],

            // ========== BAWAHAN (ID 2) - 12 Products ==========
            [
                'category_id' => 2,
                'name' => 'Stella Tailored Wide Leg Pants',
                'description' => 'Celana kulot panjang bermodel wide leg dengan garis jahitan setrika tengah yang rapi dan tegas. Berpinggang tinggi (high-waisted) yang memberikan efek kaki jenjang, berbahan semi-wool premium impor berbobot jatuh.',
                'price' => 229000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-014',
            ],
            [
                'category_id' => 2,
                'name' => 'Nami Flowy Pleated Skirt',
                'description' => 'Rok plisket panjang berbahan premium heavy silk satin yang mengalir anggun mengikuti setiap langkah Anda. Memiliki karet pinggang elastis tebal berlapis kain lembut, bebas gatal dan nyaman seharian.',
                'price' => 209000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-015',
            ],
            [
                'category_id' => 2,
                'name' => 'Jennie Utility Cargo Trouser',
                'description' => 'Celana kargo modern berpotongan longgar trendi ala urban streetwear. Dilengkapi kantong samping saku kargo fungsional dengan bahan katun drill impor yang halus, kuat, dan tetap feminin saat dipakai.',
                'price' => 249000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-016',
            ],
            [
                'category_id' => 2,
                'name' => 'Giselle Linen A-Line Skirt',
                'description' => 'Rok berkancing depan siluet A-line bernuansa alami earthy. Memiliki saku samping fungsional dengan bahan katun linen premium bertekstur sejuk alami, sangat manis untuk melengkapi OOTD akhir pekan.',
                'price' => 189000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-017',
            ],
            [
                'category_id' => 2,
                'name' => 'Aura Premium Silk Kulot',
                'description' => 'Celana kulot longgar berbahan silk sutra licin tebal berkualitas mewah. Permukaan kain memberikan efek mengkilap premium yang anggun ketika tertimpa cahaya, sangat tepat untuk pesta perkawinan maupun kasual.',
                'price' => 269000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-018',
            ],
            [
                'category_id' => 2,
                'name' => 'Iris Cotton Slit Skirt',
                'description' => 'Rok midi kasual berbahan katun berstruktur rapi dengan detail belahan samping (side slit) feminin anggun. Memiliki penutup ritsleting belakang Jepang tersembunyi yang mulus.',
                'price' => 199000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-019',
            ],
            [
                'category_id' => 2,
                'name' => 'Lana High Waist Peg Pants',
                'description' => 'Celana kantor kain siluet pencil berpinggang tinggi dengan kelengkapan ban pinggang serasi gratis. Berbahan poliester stretch impor tebal bertekstur halus yang menyerap keringat.',
                'price' => 239000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-020',
            ],
            [
                'category_id' => 2,
                'name' => 'Mimi Drawstring Linen Shorts',
                'description' => 'Celana pendek kasual berbahan katun linen sejuk alami dengan lingkar pinggang karet elastis dilengkapi tali serut. Sempurna untuk pakaian rumah mewah atau piknik pantai yang santai.',
                'price' => 149000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-BOT-021',
            ],
            [
                'category_id' => 2,
                'name' => 'Hana Tiered Maxi Skirt',
                'description' => 'Rok maxi panjang bermodel ruffle berundak (tiered) dengan motif bohemian floral lembut yang sangat estetis. Berbahan sifon ringan dilengkapi furing katun penuh untuk menjamin kenyamanan.',
                'price' => 219000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-BOT-022',
            ],
            [
                'category_id' => 2,
                'name' => 'Breezy Cotton Linen Culottes',
                'description' => 'Celana kulot semi-formal berbahan katun linen alami premium dengan tekstur garis serat rami kasual yang indah. Memiliki saku samping tersembunyi untuk kepraktisan membawa ponsel.',
                'price' => 199000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-023',
            ],
            [
                'category_id' => 2,
                'name' => 'Aero Stretch Sports Leggings',
                'description' => 'Legging olahraga yoga dan lari kompresi tinggi yang menyerap keringat seketika (quick-dry). Memiliki jahitan flatlock kuat berpinggang tinggi dari spandeks melar impor premium.',
                'price' => 189000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-024',
            ],
            [
                'category_id' => 2,
                'name' => 'Stella Satin Elegant Midi Skirt',
                'description' => 'Rok midi satin mengkilap premium impor dengan potongan bias-cut yang jatuh meliuk anggun mengikuti lekuk tubuh. Sempurna dipadankan dengan blouse maupun rajutan minimalis.',
                'price' => 219000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-BOT-025',
            ],

            // ========== DRESS (ID 3) - 13 Products ==========
            [
                'category_id' => 3,
                'name' => 'Flora Linen Botanical Midi Dress',
                'description' => 'Midi dress floral premium berbahan linen serat alami sejuk. Dihiasi motif dedaunan dan bunga botani murni bernuansa pastel estetik, dilengkapi kancing dada aktif busui-friendly dan lengan puff yang modis.',
                'price' => 289000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-026',
            ],
            [
                'category_id' => 3,
                'name' => 'Olivia Satin Slip Maxi Dress',
                'description' => 'Dress panjang model slip satin silk premium dengan kilau mewah eksklusif. Menampilkan potongan leher V-neck rendah anggun bergaya minimalis kontemporer modern, pas untuk pesta makan malam formal.',
                'price' => 299000,
                'image' => 'products/atasan_1.png',
                'sku' => 'AC-DRS-027',
            ],
            [
                'category_id' => 3,
                'name' => 'Chloe Puff Sleeve Eyelet Dress',
                'description' => 'Dress brokat katun lubang-lubang manis (eyelet lace) dengan lengan balon bervolume cantik. Berbahan 100% katun halus bersirkulasi udara tinggi khas musim panas, memberikan impresi liburan resort yang mewah.',
                'price' => 279000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-028',
            ],
            [
                'category_id' => 3,
                'name' => 'Bella Wrap Midi Dress',
                'description' => 'Dress model wrap lilit pinggang dengan potongan asimetris di bagian bawah. Memiliki detail kerah V-neck feminin yang menawan, berbahan premium crinkle airflow impor bertekstur kusut alami yang mewah.',
                'price' => 259000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-029',
            ],
            [
                'category_id' => 3,
                'name' => 'Sofia Ruffled Tiered Dress',
                'description' => 'Dress kasual longgar dengan potongan ruffle berundak yang manis. Berbahan katun poplin premium berstruktur halus dan adem, dilengkapi kerutan lengan mini karet elastis nan manis.',
                'price' => 269000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-030',
            ],
            [
                'category_id' => 3,
                'name' => 'Dahlia Smocked Floral Dress',
                'description' => 'Dress bermotif mawar pastel manis dengan detail kerut elastis (smocked) tebal di bagian dada, memberikan fleksibilitas lekuk dada yang nyaman. Sangat manis untuk piknik sore aesthetic.',
                'price' => 279000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-031',
            ],
            [
                'category_id' => 3,
                'name' => 'Alice Linen Shirt Dress',
                'description' => 'Dress kemeja multifungsi berbahan katun linen dingin premium dengan kerah tegak minimalis dan kancing baris penuh fungsional. Dilengkapi tali ikat pinggang terpisah yang dapat dilepas pasang.',
                'price' => 249000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-DRS-032',
            ],
            [
                'category_id' => 3,
                'name' => 'Grace Off-Shoulder Midi Dress',
                'description' => 'Dress sabrina dengan potongan pundak terbuka menawan yang dihiasi karet elastis berlapis lembut anti-irritasi. Berbahan katun stretch lembut yang lentur mengikuti lekuk tubuh anggun.',
                'price' => 269000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-033',
            ],
            [
                'category_id' => 3,
                'name' => 'Nora Knit Bodycon Dress',
                'description' => 'Dress rajut premium berpotongan bodycon pas badan yang menonjolkan siluet tubuh anggun secara berkelas. Berbahan benang rajut premium halus bertekstur garis-garis ribbed elastis.',
                'price' => 289000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-DRS-034',
            ],
            [
                'category_id' => 3,
                'name' => 'Rosalie Flutter Sleeve Dress',
                'description' => 'Dress panjang sifon melambai dengan detail lengan kepakan kupu-kupu (flutter sleeve) yang melayang manis. Dihiasi motif bunga mawar air cat air pastel yang sangat lembut dan artistik.',
                'price' => 299000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-035',
            ],
            [
                'category_id' => 3,
                'name' => 'Yasmin Flowy Abaya Dress',
                'description' => 'Gamis abaya modern bersiluet longgar berbahan premium wollycrepe impor yang sangat jatuh, dingin, dan tidak transparan. Potongan lengan terompet lebar berpayet mutiara mewah, wudhu-friendly.',
                'price' => 299000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-036',
            ],
            [
                'category_id' => 3,
                'name' => 'Aisha Pleated Elegant Dress',
                'description' => 'Dress panjang plisket mewah berbahan satin silk sutra jatuh berkilau premium. Dilengkapi kerutan ban pinggang karet berhias sabuk mutiara terpisah gratis, sangat elegan untuk pesta maupun hari raya.',
                'price' => 299000,
                'image' => 'products/atasan_1.png',
                'sku' => 'AC-DRS-037',
            ],
            [
                'category_id' => 3,
                'name' => 'Safiya Embroidered Kaftan Dress',
                'description' => 'Kaftan dress longgar mewah berbahan premium ceruty baby-doll halus dengan detail bordiran benang emas handmade di sekeliling dada, memberikan impresi glamour namun tetap santun berkelas.',
                'price' => 289000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-DRS-038',
            ],

            // ========== OUTER (ID 4) - 12 Products ==========
            [
                'category_id' => 4,
                'name' => 'Cozy Cable Premium Cardigan',
                'description' => 'Cardigan rajut premium rajutan tebal motif kepang bergaya luxury minimalis. Dilengkapi kancing resin cokelat kura-kura retro besar yang estetik, berbahan benang akrilik halus tebal anti-gatal.',
                'price' => 239000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-OUT-039',
            ],
            [
                'category_id' => 4,
                'name' => 'Soo-Min Structured Linen Blazer',
                'description' => 'Blazer kerah rapi semi-formal bergaya mode modern Seoul. Terbuat dari katun linen premium bertekstur rami yang tegak namun tetap lentur dingin, dilengkapi saku bobok depan berpasang rapi.',
                'price' => 279000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-OUT-040',
            ],
            [
                'category_id' => 4,
                'name' => 'Aria Sheer Organza Outer',
                'description' => 'Outer luaran transparan berbahan organza premium dengan kilau metalik sutra yang halus. Dihiasi potongan tepi laser-cut presisi rapi, memberi sentuhan OOTD kondangan instan mewah.',
                'price' => 199000,
                'image' => 'products/atasan_1.png',
                'sku' => 'AC-OUT-041',
            ],
            [
                'category_id' => 4,
                'name' => 'Yuki Oversized Knitted Vest',
                'description' => 'Rompi rajut model oversized tebal untuk gaya padu padan (layering style) di atas kemeja putih. Memiliki garis kerah V-neck rajut bertumpuk rapi dengan benang katun rajut impor dingin.',
                'price' => 179000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-OUT-042',
            ],
            [
                'category_id' => 4,
                'name' => 'Kira Crop Tweed Jacket',
                'description' => 'Jaket crop tweed rajut premium tenunan padat benang wol halus impor beraksen benang emas mewah. Kancing mutiara berbingkai logam memberikan sentuhan kemewahan Parisian chic klasik.',
                'price' => 299000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-OUT-043',
            ],
            [
                'category_id' => 4,
                'name' => 'Hana Duster Floral Kimono',
                'description' => 'Luaran kimono panjang sifon melayang bermotif floral bohemian pastel. Memiliki potongan belahan samping tinggi yang mengalir sangat cantik saat tertiup angin sepoi-sepoi.',
                'price' => 219000,
                'image' => 'products/dress_1.png',
                'sku' => 'AC-OUT-044',
            ],
            [
                'category_id' => 4,
                'name' => 'Nara Soft Ribbed Cardigan',
                'description' => 'Cardigan rajut tipis bertekstur ribbed elastis dengan deretan kancing mutiara kerang alami yang manis. Potongan ramping pas badan yang sangat cantik digunakan sebagai atasan tunggal maupun outer.',
                'price' => 189000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-OUT-045',
            ],
            [
                'category_id' => 4,
                'name' => 'Tokyo Street Denim Jacket',
                'description' => 'Jaket denim tebal premium dengan detail pencucian warna (acid-wash) kasual yang modis. Memiliki saku dada ganda dengan kancing besi kustom antirust, awet bertahun-tahun.',
                'price' => 289000,
                'image' => 'products/bawahan_1.png',
                'sku' => 'AC-OUT-046',
            ],
            [
                'category_id' => 4,
                'name' => 'Sunny Knit Summer Shrug',
                'description' => 'Outer rajut tipis rajutan jaring longgar (open-knit) yang super ringan dan adem. Berfungsi menutupi lengan namun tetap nyaman dipakai di bawah terik matahari siang hari.',
                'price' => 159000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-OUT-047',
            ],
            [
                'category_id' => 4,
                'name' => 'Breezy Linen Trench Cardigan',
                'description' => 'Outer panjang berdesain modern minimalis model jas trench berbahan linen katun premium sejuk. Dilengkapi sabuk kain lilit fungsional yang memberikan kesan pinggang ramping berkelas.',
                'price' => 269000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-OUT-048',
            ],
            [
                'category_id' => 4,
                'name' => 'Cozy Knit Oversized Cardigan',
                'description' => 'Cardigan rajut longgar premium bertekstur jaring berlubang-lubang manis yang kasual dan nyaman. Sangat aesthetic untuk dipadankan di atas tanktop atau dress tipis saat piknik.',
                'price' => 199000,
                'image' => 'products/outer_1.png',
                'sku' => 'AC-OUT-049',
            ],
            [
                'category_id' => 4,
                'name' => 'Minimalist Woolen Smart Blazer',
                'description' => 'Blazer wol terstruktur premium berpotongan lurus maskulin-chic yang rapi. Memiliki detail kerah jas klasik berkancing ganda impor, sangat mewah untuk look kantoran modern.',
                'price' => 299000,
                'image' => 'products/atasan_2.png',
                'sku' => 'AC-OUT-050',
            ]
        ];

        // Bulk insert products with slug and default settings
        foreach ($productsData as $prod) {
            $prod['slug'] = Str::slug($prod['name']);
            $prod['discount_price'] = null; // No discount by default
            $prod['stock'] = rand(8, 30); // Randomized realistic stock
            $prod['sku'] = $prod['sku'] ?? ('AC-PRD-' . rand(100, 999));
            $prod['is_promo'] = 0;
            $prod['is_active'] = 1;
            $prod['views_count'] = rand(20, 150);
            $prod['sold_count'] = rand(0, 15);

            // Randomly put a few items on sale (10% - 20% off) to populate promo slots on the homepage
            if (rand(1, 10) <= 2) {
                $discountPercent = rand(10, 20);
                $prod['discount_price'] = round($prod['price'] * (1 - $discountPercent / 100), -3); // Round to nearest 1000 Rp
                $prod['is_promo'] = 1;
            }

            Product::create($prod);
        }
        }
    }
}
