<?php

namespace Modules\Marketing\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Marketing\Services\FlashDealsService;
use Modules\Marketing\Transformers\FlashDealResource;

/**
* @group Marketing
*
* APIs for flash deal frontend
*/

class FlashDealController extends Controller
{
    protected $flashDealsService;

    public function __construct(FlashDealsService $flashDealsService)
    {
        $this->flashDealsService = $flashDealsService;
    }

    /**
        * Flash Deal
        * @response{
      *      "flash_deal": {
      *          "id": 1,
      *          "title": "test deal",
      *          "background_color": "white",
      *          "text_color": "#444444",
      *          "start_date": "2021-05-31",
      *          "end_date": "2021-06-30",
      *          "slug": "test-deal-ek75m",
      *          "banner_image": "uploads/images/01-06-2021/60b62e72a3122.png",
      *          "status": 1,
      *          "is_featured": 0,
      *          "created_by": 1,
      *          "updated_by": 1,
      *          "created_at": "2021-06-01T12:56:18.000000Z",
      *          "updated_at": "2021-06-02T10:35:10.000000Z",
      *          "AllProducts": {
      *              "current_page": 1,
      *              "data": [
      *                  {
      *                      "id": 1,
      *                      "flash_deal_id": 1,
      *                      "seller_product_id": 2,
      *                      "discount": 20,
      *                      "discount_type": 0,
      *                      "status": 1,
      *                      "created_at": "2021-06-01T12:56:18.000000Z",
      *                      "updated_at": "2021-06-02T10:36:20.000000Z",
      *                      "product": {
      *                          "id": 2,
      *                          "user_id": 4,
      *                          "product_id": 4,
      *                          "tax": 5,
      *                          "tax_type": "0",
      *                          "discount": 5,
      *                          "discount_type": "0",
      *                          "discount_start_date": "05/25/2021",
      *                          "discount_end_date": "06/30/2021",
      *                          "product_name": "Xiaomi MI 5X",
      *                          "slug": "xiaomi-mi-5x-4",
      *                          "thum_img": null,
      *                          "status": 1,
      *                          "stock_manage": 0,
      *                          "is_approved": 0,
      *                          "min_sell_price": 200,
      *                          "max_sell_price": 220,
      *                          "total_sale": 3,
      *                          "avg_rating": 4.03,
      *                          "recent_view": "2021-06-08 10:06:56",
      *                          "created_at": "2021-05-29T10:25:59.000000Z",
      *                          "updated_at": "2021-06-08T04:06:56.000000Z",
      *                          "variantDetails": [
      *                              {
      *                                  "value": [
      *                                      "4GB-32GB",
      *                                      "4GB-64GB"
      *                                  ],
      *                                  "code": [
      *                                      "4GB-32GB",
      *                                      "4GB-64GB"
      *                                  ],
      *                                  "attr_val_id": [
      *                                      13,
      *                                      14
      *                                  ],
      *                                  "name": "Storage",
      *                                  "attr_id": 3
      *                              },
      *                              {
      *                                  "value": [
      *                                      "Black",
      *                                      "Red",
      *                                      "Gold"
      *                                  ],
      *                                  "code": [
      *                                      "black",
      *                                      "#f40c0c",
      *                                      "#fff2cc"
      *                                  ],
      *                                  "attr_val_id": [
      *                                      5,
      *                                      6,
      *                                      12
      *                                  ],
      *                                  "name": "Color",
      *                                  "attr_id": 1
      *                              }
      *                          ],
      *                          "MaxSellingPrice": 220,
      *                          "hasDeal": {
      *                              "id": 1,
      *                              "flash_deal_id": 1,
      *                              "seller_product_id": 2,
      *                              "discount": 20,
      *                              "discount_type": 0,
      *                              "status": 1,
      *                              "created_at": "2021-06-01T12:56:18.000000Z",
      *                              "updated_at": "2021-06-02T10:36:20.000000Z"
      *                          },
      *                          "rating": 0,
      *                          "product": {
      *                              "id": 4,
      *                              "product_name": "Xiaomi MI 5X",
      *                              "product_type": 2,
      *                              "unit_type_id": 1,
      *                              "brand_id": 1,
      *                              "category_id": 6,
      *                              "thumbnail_image_source": "uploads/images/29-05-2021/60b1eed81a7fb.jpeg",
      *                              "barcode_type": "C39",
      *                              "model_number": "mi 5x",
      *                              "shipping_type": 0,
      *                              "shipping_cost": 0,
      *                              "discount_type": "1",
      *                              "discount": 0,
      *                              "tax_type": "0",
      *                              "tax": 5,
      *                              "pdf": null,
      *                              "video_provider": "youtube",
      *                              "video_link": null,
      *                              "description": "<p>test product</p>",
      *                              "specification": "<p>test product</p>",
      *                              "minimum_order_qty": 1,
      *                              "max_order_qty": 5,
      *                              "meta_title": null,
      *                              "meta_description": null,
      *                              "meta_image": null,
      *                              "is_physical": 1,
      *                              "is_approved": 1,
      *                              "display_in_details": 1,
      *                              "requested_by": 1,
      *                              "created_by": 1,
      *                              "slug": "xiaomi-mi-5x",
      *                              "updated_by": null,
      *                              "created_at": "2021-05-29T07:35:52.000000Z",
      *                              "updated_at": "2021-05-29T07:35:52.000000Z"
      *                          },
      *                          "skus": [
      *                              {
      *                                  "id": 1,
      *                                  "user_id": 4,
      *                                  "product_id": 2,
      *                                  "product_sku_id": "5",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 200,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-29T10:25:59.000000Z",
      *                                  "updated_at": "2021-05-29T10:25:59.000000Z",
      *                                  "product_variations": [
      *                                      {
      *                                          "id": 3,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 5,
      *                                          "attribute_id": 3,
      *                                          "attribute_value_id": 13,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute_value": {
      *                                              "id": 13,
      *                                              "value": "4GB-32GB",
      *                                              "attribute_id": 3,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": null,
      *                                              "color": null
      *                                          },
      *                                          "attribute": {
      *                                              "id": 3,
      *                                              "name": "Storage",
      *                                              "display_type": "radio_button",
      *                                              "description": null,
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": "2021-05-29T07:31:25.000000Z"
      *                                          }
      *                                      },
      *                                      {
      *                                          "id": 4,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 5,
      *                                          "attribute_id": 1,
      *                                          "attribute_value_id": 5,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 1,
      *                                              "name": "Color",
      *                                              "display_type": "radio_button",
      *                                              "description": "null",
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2018-11-04T20:12:26.000000Z",
      *                                              "updated_at": "2018-11-04T20:12:26.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 5,
      *                                              "value": "black",
      *                                              "attribute_id": 1,
      *                                              "created_at": "2021-05-29T07:30:19.000000Z",
      *                                              "updated_at": "2021-05-29T07:30:19.000000Z",
      *                                              "color": {
      *                                                  "id": 1,
      *                                                  "attribute_value_id": 5,
      *                                                  "name": "Black",
      *                                                  "created_at": "2021-05-29T07:30:19.000000Z",
      *                                                  "updated_at": "2021-05-29T07:30:19.000000Z"
      *                                              }
      *                                          }
      *                                      }
      *                                  ]
      *                              },
      *                              {
      *                                  "id": 2,
      *                                  "user_id": 4,
      *                                  "product_id": 2,
      *                                  "product_sku_id": "6",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 200,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-29T10:25:59.000000Z",
      *                                  "updated_at": "2021-05-29T10:25:59.000000Z",
      *                                  "product_variations": [
      *                                      {
      *                                          "id": 5,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 6,
      *                                          "attribute_id": 3,
      *                                          "attribute_value_id": 13,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 3,
      *                                              "name": "Storage",
      *                                              "display_type": "radio_button",
      *                                              "description": null,
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": "2021-05-29T07:31:25.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 13,
      *                                              "value": "4GB-32GB",
      *                                              "attribute_id": 3,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": null,
      *                                              "color": null
      *                                          }
      *                                      },
      *                                      {
      *                                          "id": 6,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 6,
      *                                          "attribute_id": 1,
      *                                          "attribute_value_id": 6,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 1,
      *                                              "name": "Color",
      *                                              "display_type": "radio_button",
      *                                              "description": "null",
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2018-11-04T20:12:26.000000Z",
      *                                              "updated_at": "2018-11-04T20:12:26.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 6,
      *                                              "value": "#f40c0c",
      *                                              "attribute_id": 1,
      *                                              "created_at": "2021-05-29T07:30:19.000000Z",
      *                                              "updated_at": "2021-05-29T07:30:19.000000Z",
      *                                              "color": {
      *                                                  "id": 2,
      *                                                  "attribute_value_id": 6,
      *                                                  "name": "Red",
      *                                                  "created_at": "2021-05-29T07:30:19.000000Z",
      *                                                  "updated_at": "2021-05-29T07:30:19.000000Z"
      *                                              }
      *                                          }
      *                                      }
      *                                  ]
      *                              },
      *                              {
      *                                  "id": 3,
      *                                  "user_id": 4,
      *                                  "product_id": 2,
      *                                  "product_sku_id": "7",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 200,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-29T10:25:59.000000Z",
      *                                  "updated_at": "2021-05-29T10:25:59.000000Z",
      *                                  "product_variations": [
      *                                      {
      *                                          "id": 7,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 7,
      *                                          "attribute_id": 3,
      *                                          "attribute_value_id": 13,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 3,
      *                                              "name": "Storage",
      *                                              "display_type": "radio_button",
      *                                              "description": null,
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": "2021-05-29T07:31:25.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 13,
      *                                              "value": "4GB-32GB",
      *                                              "attribute_id": 3,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": null,
      *                                              "color": null
      *                                          }
      *                                      },
      *                                      {
      *                                          "id": 8,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 7,
      *                                          "attribute_id": 1,
      *                                          "attribute_value_id": 12,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 1,
      *                                              "name": "Color",
      *                                              "display_type": "radio_button",
      *                                              "description": "null",
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2018-11-04T20:12:26.000000Z",
      *                                              "updated_at": "2018-11-04T20:12:26.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 12,
      *                                              "value": "#fff2cc",
      *                                              "attribute_id": 1,
      *                                              "created_at": "2021-05-29T07:30:19.000000Z",
      *                                              "updated_at": "2021-05-29T07:30:19.000000Z",
      *                                              "color": {
      *                                                  "id": 8,
      *                                                  "attribute_value_id": 12,
      *                                                  "name": "Gold",
      *                                                  "created_at": "2021-05-29T07:30:19.000000Z",
      *                                                  "updated_at": "2021-05-29T07:30:19.000000Z"
      *                                              }
      *                                          }
      *                                      }
      *                                  ]
      *                              },
      *                              {
      *                                  "id": 4,
      *                                  "user_id": 4,
      *                                  "product_id": 2,
      *                                  "product_sku_id": "8",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 220,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-29T10:25:59.000000Z",
      *                                  "updated_at": "2021-05-29T10:25:59.000000Z",
      *                                  "product_variations": [
      *                                      {
      *                                          "id": 9,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 8,
      *                                          "attribute_id": 3,
      *                                          "attribute_value_id": 14,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 3,
      *                                              "name": "Storage",
      *                                              "display_type": "radio_button",
      *                                              "description": null,
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": "2021-05-29T07:31:25.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 14,
      *                                              "value": "4GB-64GB",
      *                                              "attribute_id": 3,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": null,
      *                                              "color": null
      *                                          }
      *                                      },
      *                                      {
      *                                          "id": 10,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 8,
      *                                          "attribute_id": 1,
      *                                          "attribute_value_id": 5,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 1,
      *                                              "name": "Color",
      *                                              "display_type": "radio_button",
      *                                              "description": "null",
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2018-11-04T20:12:26.000000Z",
      *                                              "updated_at": "2018-11-04T20:12:26.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 5,
      *                                              "value": "black",
      *                                              "attribute_id": 1,
      *                                              "created_at": "2021-05-29T07:30:19.000000Z",
      *                                              "updated_at": "2021-05-29T07:30:19.000000Z",
      *                                              "color": {
      *                                                  "id": 1,
      *                                                  "attribute_value_id": 5,
      *                                                  "name": "Black",
      *                                                  "created_at": "2021-05-29T07:30:19.000000Z",
      *                                                  "updated_at": "2021-05-29T07:30:19.000000Z"
      *                                              }
      *                                          }
      *                                      }
      *                                  ]
      *                              },
      *                              {
      *                                  "id": 5,
      *                                  "user_id": 4,
      *                                  "product_id": 2,
      *                                  "product_sku_id": "9",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 220,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-29T10:25:59.000000Z",
      *                                  "updated_at": "2021-05-29T10:25:59.000000Z",
      *                                  "product_variations": [
      *                                      {
      *                                          "id": 11,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 9,
      *                                          "attribute_id": 3,
      *                                          "attribute_value_id": 14,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 3,
      *                                              "name": "Storage",
      *                                              "display_type": "radio_button",
      *                                              "description": null,
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": "2021-05-29T07:31:25.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 14,
      *                                              "value": "4GB-64GB",
      *                                              "attribute_id": 3,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": null,
      *                                              "color": null
      *                                          }
      *                                      },
      *                                      {
      *                                          "id": 12,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 9,
      *                                          "attribute_id": 1,
      *                                          "attribute_value_id": 6,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 1,
      *                                              "name": "Color",
      *                                              "display_type": "radio_button",
      *                                              "description": "null",
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2018-11-04T20:12:26.000000Z",
      *                                              "updated_at": "2018-11-04T20:12:26.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 6,
      *                                              "value": "#f40c0c",
      *                                              "attribute_id": 1,
      *                                              "created_at": "2021-05-29T07:30:19.000000Z",
      *                                              "updated_at": "2021-05-29T07:30:19.000000Z",
      *                                              "color": {
      *                                                  "id": 2,
      *                                                  "attribute_value_id": 6,
      *                                                  "name": "Red",
      *                                                  "created_at": "2021-05-29T07:30:19.000000Z",
      *                                                  "updated_at": "2021-05-29T07:30:19.000000Z"
      *                                              }
      *                                          }
      *                                      }
      *                                  ]
      *                              },
      *                              {
      *                                  "id": 8,
      *                                  "user_id": 4,
      *                                  "product_id": 2,
      *                                  "product_sku_id": "10",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 220,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-30T04:41:01.000000Z",
      *                                  "updated_at": "2021-05-30T04:41:01.000000Z",
      *                                  "product_variations": [
      *                                      {
      *                                          "id": 13,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 10,
      *                                          "attribute_id": 3,
      *                                          "attribute_value_id": 14,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 3,
      *                                              "name": "Storage",
      *                                              "display_type": "radio_button",
      *                                              "description": null,
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": "2021-05-29T07:31:25.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 14,
      *                                              "value": "4GB-64GB",
      *                                              "attribute_id": 3,
      *                                              "created_at": "2021-05-29T07:31:25.000000Z",
      *                                              "updated_at": null,
      *                                              "color": null
      *                                          }
      *                                      },
      *                                      {
      *                                          "id": 14,
      *                                          "product_id": 4,
      *                                          "product_sku_id": 10,
      *                                          "attribute_id": 1,
      *                                          "attribute_value_id": 12,
      *                                          "created_by": null,
      *                                          "updated_by": null,
      *                                          "created_at": "2021-05-29T07:35:52.000000Z",
      *                                          "updated_at": "2021-05-29T07:35:52.000000Z",
      *                                          "attribute": {
      *                                              "id": 1,
      *                                              "name": "Color",
      *                                              "display_type": "radio_button",
      *                                              "description": "null",
      *                                              "status": 1,
      *                                              "created_by": null,
      *                                              "updated_by": null,
      *                                              "created_at": "2018-11-04T20:12:26.000000Z",
      *                                              "updated_at": "2018-11-04T20:12:26.000000Z"
      *                                          },
      *                                          "attribute_value": {
      *                                              "id": 12,
      *                                              "value": "#fff2cc",
      *                                              "attribute_id": 1,
      *                                              "created_at": "2021-05-29T07:30:19.000000Z",
      *                                              "updated_at": "2021-05-29T07:30:19.000000Z",
      *                                              "color": {
      *                                                  "id": 8,
      *                                                  "attribute_value_id": 12,
      *                                                  "name": "Gold",
      *                                                  "created_at": "2021-05-29T07:30:19.000000Z",
      *                                                  "updated_at": "2021-05-29T07:30:19.000000Z"
      *                                              }
      *                                          }
      *                                      }
      *                                  ]
      *                              }
      *                          ],
      *                          "reviews": [
      *                              {
      *                                  "id": 1,
      *                                  "customer_id": 5,
      *                                  "seller_id": 4,
      *                                  "product_id": 2,
      *                                  "order_id": 5,
      *                                  "package_id": 8,
      *                                  "review": "test product review",
      *                                  "rating": 4,
      *                                  "is_anonymous": 1,
      *                                  "status": 0,
      *                                  "created_at": "2021-06-08T12:31:32.000000Z",
      *                                  "updated_at": "2021-06-08T12:31:32.000000Z"
      *                              }
      *                          ]
      *                      }
      *                  },
      *                  {
      *                      "id": 2,
      *                      "flash_deal_id": 1,
      *                      "seller_product_id": 3,
      *                      "discount": 50,
      *                      "discount_type": 1,
      *                      "status": 1,
      *                      "created_at": "2021-06-01T12:56:18.000000Z",
      *                      "updated_at": "2021-06-01T13:08:58.000000Z",
      *                      "product": {
      *                          "id": 3,
      *                          "user_id": 4,
      *                          "product_id": 3,
      *                          "tax": 15,
      *                          "tax_type": "0",
      *                          "discount": 50,
      *                          "discount_type": "1",
      *                          "discount_start_date": "05/01/2021",
      *                          "discount_end_date": "06/30/2021",
      *                          "product_name": "KTM RC 390",
      *                          "slug": "ktm-rc-390-4",
      *                          "thum_img": null,
      *                          "status": 1,
      *                          "stock_manage": 0,
      *                          "is_approved": 0,
      *                          "min_sell_price": 6500,
      *                          "max_sell_price": 6500,
      *                          "total_sale": 1,
      *                          "avg_rating": 0,
      *                          "recent_view": "2021-05-29 16:28:14",
      *                          "created_at": "2021-05-29T10:28:14.000000Z",
      *                          "updated_at": "2021-05-30T04:29:14.000000Z",
      *                          "variantDetails": [],
      *                          "MaxSellingPrice": 6600,
      *                          "hasDeal": {
      *                              "id": 2,
      *                              "flash_deal_id": 1,
      *                              "seller_product_id": 3,
      *                              "discount": 50,
      *                              "discount_type": 1,
      *                              "status": 1,
      *                              "created_at": "2021-06-01T12:56:18.000000Z",
      *                              "updated_at": "2021-06-01T13:08:58.000000Z"
      *                          },
      *                          "rating": 0,
      *                          "product": {
      *                              "id": 3,
      *                              "product_name": "KTM RC 390",
      *                              "product_type": 1,
      *                              "unit_type_id": 1,
      *                              "brand_id": 2,
      *                              "category_id": 5,
      *                              "thumbnail_image_source": "uploads/images/29-05-2021/60b1e99781fbb.png",
      *                              "barcode_type": "C39",
      *                              "model_number": "ktm-rc-390",
      *                              "shipping_type": 0,
      *                              "shipping_cost": 0,
      *                              "discount_type": "1",
      *                              "discount": 0,
      *                              "tax_type": "0",
      *                              "tax": 15,
      *                              "pdf": null,
      *                              "video_provider": "youtube",
      *                              "video_link": null,
      *                              "description": "<p>test product</p>",
      *                              "specification": "<p>test product</p>",
      *                              "minimum_order_qty": 1,
      *                              "max_order_qty": 5,
      *                              "meta_title": null,
      *                              "meta_description": null,
      *                              "meta_image": null,
      *                              "is_physical": 1,
      *                              "is_approved": 1,
      *                              "display_in_details": 1,
      *                              "requested_by": 1,
      *                              "created_by": 1,
      *                              "slug": "ktm-rc-390",
      *                              "updated_by": null,
      *                              "created_at": "2021-05-29T07:13:28.000000Z",
      *                              "updated_at": "2021-05-29T07:13:28.000000Z"
      *                          },
      *                          "skus": [
      *                              {
      *                                  "id": 7,
      *                                  "user_id": 4,
      *                                  "product_id": 3,
      *                                  "product_sku_id": "4",
      *                                  "product_stock": 0,
      *                                  "purchase_price": 0,
      *                                  "selling_price": 6600,
      *                                  "status": 1,
      *                                  "created_at": "2021-05-29T10:28:14.000000Z",
      *                                  "updated_at": "2021-05-30T04:32:25.000000Z",
      *                                  "product_variations": []
      *                              }
      *                          ],
      *                          "reviews": []
      *                      }
      *                  }
      *              ],
      *              "first_page_url": "http://ecommerce.test/api/marketing/flash-deal?page=1",
      *              "from": 1,
      *              "last_page": 1,
      *              "last_page_url": "http://ecommerce.test/api/marketing/flash-deal?page=1",
      *              "links": [
      *                  {
      *                      "url": null,
      *                      "label": "&laquo; Previous",
      *                      "active": false
      *                  },
      *                  {
      *                      "url": "http://ecommerce.test/api/marketing/flash-deal?page=1",
      *                      "label": "1",
      *                      "active": true
      *                  },
      *                  {
      *                      "url": null,
      *                      "label": "Next &raquo;",
      *                      "active": false
      *                  }
      *              ],
      *              "next_page_url": null,
      *              "path": "http://ecommerce.test/api/marketing/flash-deal",
      *              "per_page": 10,
      *              "prev_page_url": null,
      *              "to": 2,
      *              "total": 2
      *          }
      *      }
     * }

    */

    public function getActiveFlashDeal(){

        $flash_deal = new FlashDealResource($this->flashDealsService->getActiveFlashDeal());

        if($flash_deal){
            return response()->json([
                'flash_deal' => $flash_deal
            ],200);
        }else{
            return response()->json([
                'message' => trans('app.Not found')
            ],404);
        }
    }
}
