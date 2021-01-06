import 'package:fluttermultigrocery/viewobject/Item_color.dart';
import 'package:fluttermultigrocery/viewobject/category.dart';
import 'package:fluttermultigrocery/viewobject/customized_header.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';
import 'package:fluttermultigrocery/viewobject/sub_category.dart';
import 'package:quiver/core.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/rating_detail.dart';
import 'add_on.dart';
import 'default_photo.dart';

class Product extends PsObject<Product> {
  Product(
      {this.id,
      this.catId,
      this.subCatId,
      this.productUnit,
      this.productMeasurement,
      this.name,
      this.description,
      this.originalPrice,
      this.unitPrice,
      this.shippingCost,
      this.minimumOrder,
      this.maximumOrder,
      this.productUnitValue,
      this.searchTag,
      this.ingredient,
      this.nutrient,
      this.highlightInformation,
      this.isDiscount,
      this.isFeatured,
      this.isAvailable,
      this.code,
      this.status,
      this.addedDate,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.updatedFlag,
      this.overallRating,
      this.touchCount,
      this.favouriteCount,
      this.likeCount,
      this.featuredDate,
      this.addedDateStr,
      this.transStatus,
      this.itemColorList,
      this.isliked,
      this.isFavourited,
      this.isPurchased,
      this.imageCount,
      this.commentHeaderCount,
      this.currencySymbol,
      this.currencyShortForm,
      this.discountAmount,
      this.discountPercent,
      this.discountValue,
      this.defaultPhoto,
      this.category,
      this.shop,
      this.subCategory,
      this.customizedHeaderList,
      this.addOnList,
      this.ratingDetail});

  String id;
  String catId;
  String subCatId;
  String productUnit;
  String productMeasurement;
  String name;
  String description;
  String originalPrice;
  String unitPrice;
  String shippingCost;
  String minimumOrder;
  String maximumOrder;
  String productUnitValue;
  String searchTag;
  String ingredient;
  String nutrient;
  String highlightInformation;
  String isDiscount;
  String isFeatured;
  String isAvailable;
  String code;
  String status;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String updatedFlag;
  String overallRating;
  String touchCount;
  String favouriteCount;
  String likeCount;
  String featuredDate;
  String addedDateStr;
  String transStatus;
  DefaultPhoto defaultPhoto;
  Category category;
  Shop shop;
  SubCategory subCategory;
  List<ItemColor> itemColorList;
  String isliked;
  String isFavourited;
  String isPurchased; // to remove later
  String imageCount;
  String commentHeaderCount;
  String currencySymbol;
  String currencyShortForm;
  String discountAmount;
  String discountPercent;
  String discountValue;
  List<CustomizedHeader> customizedHeaderList;
  List<AddOn> addOnList;
  RatingDetail ratingDetail;

  @override
  bool operator ==(dynamic other) => other is Product && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  Product fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return Product(
          id: dynamicData['id'],
          catId: dynamicData['cat_id'],
          subCatId: dynamicData['sub_cat_id'],
          productUnit: dynamicData['product_unit'],
          productMeasurement: dynamicData['product_measurement'],
          name: dynamicData['name'],
          description: dynamicData['description'],
          originalPrice: dynamicData['original_price'],
          unitPrice: dynamicData['unit_price'],
          shippingCost: dynamicData['shipping_cost'],
          minimumOrder: dynamicData['minimum_order'],
          maximumOrder: dynamicData['maximum_order'],
          productUnitValue: dynamicData['product_unit_value'],
          searchTag: dynamicData['search_tag'],
          ingredient: dynamicData['ingredient'],
          nutrient: dynamicData['nutrient'],
          highlightInformation: dynamicData['highlight_information'],
          isDiscount: dynamicData['is_discount'],
          isFeatured: dynamicData['is_featured'],
          isAvailable: dynamicData['is_available'],
          code: dynamicData['code'],
          status: dynamicData['status'],
          addedDate: dynamicData['added_date'],
          addedUserId: dynamicData['added_user_id'],
          updatedDate: dynamicData['updated_date'],
          updatedUserId: dynamicData['updated_user_id'],
          updatedFlag: dynamicData['updated_flag'],
          overallRating: dynamicData['overall_rating'],
          touchCount: dynamicData['touch_count'],
          favouriteCount: dynamicData['favourite_count'],
          likeCount: dynamicData['like_count'],
          featuredDate: dynamicData['featured_date'],
          addedDateStr: dynamicData['added_date_str'],
          transStatus: dynamicData['trans_status'],
          isliked: dynamicData['is_liked'],
          isFavourited: dynamicData['is_favourited'],
          isPurchased: dynamicData['is_purchased'],
          imageCount: dynamicData['image_count'],
          commentHeaderCount: dynamicData['comment_header_count'],
          currencySymbol: dynamicData['currency_symbol'],
          currencyShortForm: dynamicData['currency_short_form'],
          discountAmount: dynamicData['discount_amount'],
          discountPercent: dynamicData['discount_percent'],
          discountValue: dynamicData['discount_value'],
          itemColorList: ItemColor().fromMapList(dynamicData['colors']),
          defaultPhoto: DefaultPhoto().fromMap(dynamicData['default_photo']),
          category: Category().fromMap(dynamicData['category']),
          shop: Shop().fromMap(dynamicData['shop']),
          subCategory: SubCategory().fromMap(dynamicData['sub_category']),
          customizedHeaderList:
              CustomizedHeader().fromMapList(dynamicData['customized_header']),
          addOnList: AddOn().fromMapList(dynamicData['addon']),
          ratingDetail: RatingDetail().fromMap(dynamicData['rating_details']));
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['cat_id'] = object.catId;
      data['sub_cat_id'] = object.subCatId;
      data['product_unit'] = object.productUnit;
      data['product_measurement'] = object.productMeasurement;
      data['name'] = object.name;
      data['description'] = object.description;
      data['original_price'] = object.originalPrice;
      data['unit_price'] = object.unitPrice;
      data['shipping_cost'] = object.shippingCost;
      data['minimum_order'] = object.minimumOrder;
      data['maximum_order'] = object.maximumOrder;
      data['product_unit_value'] = object.productUnitValue;
      data['search_tag'] = object.searchTag;
      data['ingredient'] = object.ingredient;
      data['nutrient'] = object.nutrient;
      data['highlight_information'] = object.highlightInformation;
      data['is_discount'] = object.isDiscount;
      data['is_featured'] = object.isFeatured;
      data['is_available'] = object.isAvailable;
      data['code'] = object.code;
      data['status'] = object.status;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedDate;
      data['updated_user_id'] = object.updatedUserId;
      data['updated_flag'] = object.updatedFlag;
      data['overall_rating'] = object.overallRating;
      data['touch_count'] = object.touchCount;
      data['favourite_count'] = object.favouriteCount;
      data['like_count'] = object.likeCount;
      data['featured_date'] = object.featuredDate;
      data['added_date_str'] = object.addedDateStr;
      data['trans_status'] = object.transStatus;
      data['is_liked'] = object.isliked;
      data['is_favourited'] = object.isFavourited;
      data['is_purchased'] = object.isPurchased;
      data['image_count'] = object.imageCount;
      data['comment_header_count'] = object.commentHeaderCount;
      data['currency_symbol'] = object.currencySymbol;
      data['currency_short_form'] = object.currencyShortForm;
      data['discount_amount'] = object.discountAmount;
      data['discount_percent'] = object.discountPercent;
      data['discount_value'] = object.discountValue;
      data['colors'] = ItemColor().toMapList(object.itemColorList);
      data['default_photo'] = DefaultPhoto().toMap(object.defaultPhoto);
      data['category'] = Category().toMap(object.category);
      data['shop'] = Shop().toMap(object.shop);
      data['sub_category'] = SubCategory().toMap(object.subCategory);
      data['customized_header'] =
          CustomizedHeader().toMapList(object.customizedHeaderList);
      data['addon'] = AddOn().toMapList(object.addOnList);
      // data['food_additional'] = FoodAdditional().toMapList(object.foodAdditional);
      data['rating_details'] = RatingDetail().toMap(object.ratingDetail);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<Product> fromMapList(List<dynamic> dynamicDataList) {
    final List<Product> newFeedList = <Product>[];
    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        if (json != null) {
          newFeedList.add(fromMap(json));
        }
      }
    }
    return newFeedList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> dynamicList = <Map<String, dynamic>>[];

    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          dynamicList.add(toMap(data));
        }
      }
    }
    return dynamicList;
  }
}
