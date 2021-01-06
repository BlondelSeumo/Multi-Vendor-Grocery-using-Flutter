import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';

class TransactionDetail extends PsObject<TransactionDetail> {
  TransactionDetail(
      {this.id,
      this.transactionsHeaderId,
      this.shopId,
      this.productId,
      this.productCustomizedId,
      this.productName,
      this.productCustomizedName,
      this.productCustomizedPrice,
      this.productColorId,
      this.productColorCode,
      this.originalPrice,
      this.price,
      this.discountAmount,
      this.qty,
      this.discountValue,
      this.discountPercent,
      this.addedDate,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.updatedFlag,
      this.currencySymbol,
      this.currencyShortForm,
      this.productUnit,
      this.productMeasurement,
      this.productAddonId,
      this.productAddonName,
      this.productAddonPrice,
      this.addedDateStr});
  String id;
  String transactionsHeaderId;
  String productId;
  String shopId;
  String productCustomizedId;
  String productName;
  String productCustomizedName;
  String productCustomizedPrice;
  String productColorId;
  String productColorCode;
  String originalPrice;
  String price;
  String discountAmount;
  String qty;
  String discountValue;
  String discountPercent;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String updatedFlag;
  String currencySymbol;
  String currencyShortForm;
  String productUnit;
  String productMeasurement;
  String productAddonId;
  String productAddonName;
  String productAddonPrice;
  String addedDateStr;

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  TransactionDetail fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return TransactionDetail(
          id: dynamicData['id'],
          transactionsHeaderId: dynamicData['transactions_header_id'],
          shopId: dynamicData['shop_id'],
          productId: dynamicData['product_id'],
          productCustomizedId: dynamicData['product_customized_id'],
          productName: dynamicData['product_name'],
          productCustomizedName: dynamicData['product_customized_name'],
          productCustomizedPrice: dynamicData['product_customized_price'],
          productColorId: dynamicData['product_color_id'],
          productColorCode: dynamicData['product_color_code'],
          originalPrice: dynamicData['original_price'],
          price: dynamicData['price'],
          discountAmount: dynamicData['discount_amount'],
          qty: dynamicData['qty'],
          discountValue: dynamicData['discount_value'],
          discountPercent: dynamicData['discount_percent'],
          addedDate: dynamicData['added_date'],
          addedUserId: dynamicData['added_user_id'],
          updatedDate: dynamicData['updated_date'],
          updatedUserId: dynamicData['updated_user_id'],
          updatedFlag: dynamicData['updated_flag'],
          currencySymbol: dynamicData['currency_symbol'],
          currencyShortForm: dynamicData['currency_short_form'],
          productUnit: dynamicData['product_unit'],
          productMeasurement: dynamicData['product_measurement'],
          productAddonId: dynamicData['product_addon_id'],
          productAddonName: dynamicData['product_addon_name'],
          productAddonPrice: dynamicData['product_addon_price'],
          addedDateStr: dynamicData['added_date_str']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['transactions_header_id'] = object.transactionsHeaderId;
      data['shop_id'] = object.shopId;
      data['product_id'] = object.productId;
      data['product_customized_id'] = object.productCustomizedId;
      data['product_name'] = object.productName;
      data['product_customized_name'] = object.productCustomizedName;
      data['product_customized_price'] = object.productCustomizedPrice;
      data['product_color_id'] = object.productColorId;
      data['product_color_code'] = object.productColorCode;
      data['original_price'] = object.originalPrice;
      data['price'] = object.price;
      data['discount_amount'] = object.discountAmount;
      data['qty'] = object.qty;
      data['discount_value'] = object.discountValue;
      data['discount_percent'] = object.discountPercent;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedDate;
      data['updated_user_id'] = object.updatedUserId;
      data['updated_flag'] = object.updatedFlag;
      data['currency_symbol'] = object.currencySymbol;
      data['currency_short_form'] = object.currencyShortForm;
      data['product_unit'] = object.productUnit;
      data['product_measurement'] = object.productMeasurement;
      data['product_addon_id'] = object.productAddonId;
      data['product_addon_name'] = object.productAddonName;
      data['product_addon_price'] = object.productAddonPrice;
      data['added_date_str'] = object.addedDateStr;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<TransactionDetail> fromMapList(List<dynamic> dynamicDataList) {
    final List<TransactionDetail> subCategoryList = <TransactionDetail>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          subCategoryList.add(fromMap(dynamicData));
        }
      }
    }
    return subCategoryList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
