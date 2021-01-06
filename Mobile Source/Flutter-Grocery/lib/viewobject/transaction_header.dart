import 'dart:core';
import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/transaction_status.dart';

class TransactionHeader extends PsObject<TransactionHeader> {
  TransactionHeader(
      {this.id,
      this.userId,
      this.subTotalAmount,
      this.discountAmount,
      this.cuponDiscountAmount,
      this.taxAmount,
      this.taxPercent,
      this.shippingAmount,
      this.shippingTaxPercent,
      this.balanceAmount,
      this.totalItemAmount,
      this.totalItemCount,
      this.contactName,
      this.contactPhone,
      this.contactEmail,
      this.contactAddress,
      this.contactAreaId,
      this.paymentMethod,
      this.addedDate,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.updatedFlag,
      this.transStatusId,
      this.deliveryStatusId,
      this.paymentStatusId,
      this.deliveryBoyId,
      this.currencySymbol,
      this.currencyShortForm,
      this.transCode,
      this.memo,
      this.razorId,
      this.addedDateStr,
      this.pickAtShop,
      this.deliveryPickupDate,
      this.deliveryPickupTime,
      this.transStatus});

  String id;
  String userId;
  String subTotalAmount;
  String discountAmount;
  String balanceAmount;
  String cuponDiscountAmount;
  String taxAmount;
  String taxPercent;
  String shippingAmount;
  String shippingTaxPercent;
  String totalItemAmount;
  String totalItemCount;
  String contactName;
  String contactPhone;
  String contactEmail;
  String contactAddress;
  String contactAreaId;
  String paymentMethod;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String updatedFlag;
  String transStatusId;
  String deliveryStatusId;
  String paymentStatusId;
  String deliveryBoyId;
  String currencySymbol;
  String currencyShortForm;
  String transCode;
  String memo;
  String razorId;
  String addedDateStr;
  String pickAtShop;
  String deliveryPickupDate;
  String deliveryPickupTime;
  TransactionStatus transStatus;

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  TransactionHeader fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return TransactionHeader(
        id: dynamicData['id'],
        userId: dynamicData['user_id'],
        subTotalAmount: dynamicData['sub_total_amount'],
        discountAmount: dynamicData['discount_amount'],
        cuponDiscountAmount: dynamicData['coupon_discount_amount'],
        taxAmount: dynamicData['tax_amount'],
        taxPercent: dynamicData['tax_percent'],
        shippingAmount: dynamicData['shipping_amount'],
        shippingTaxPercent: dynamicData['shipping_tax_percent'],
        balanceAmount: dynamicData['balance_amount'],
        totalItemAmount: dynamicData['total_item_amount'],
        totalItemCount: dynamicData['total_item_count'],
        contactName: dynamicData['contact_name'],
        contactPhone: dynamicData['contact_phone'],
        contactEmail: dynamicData['contact_email'],
        contactAddress: dynamicData['contact_address'],
        contactAreaId: dynamicData['contact_area_id'],
        paymentMethod: dynamicData['payment_method'],
        addedDate: dynamicData['added_date'],
        addedUserId: dynamicData['added_user_id'],
        updatedDate: dynamicData['updated_date'],
        updatedUserId: dynamicData['updated_user_id'],
        updatedFlag: dynamicData['updated_flag'],
        transStatusId: dynamicData['trans_status_id'],
        deliveryStatusId: dynamicData['delivery_status_id'],
        paymentStatusId: dynamicData['payment_status_id'],
        deliveryBoyId: dynamicData['delivery_boy_id'],
        currencySymbol: dynamicData['currency_symbol'],
        currencyShortForm: dynamicData['currency_short_form'],
        transCode: dynamicData['trans_code'],
        memo: dynamicData['memo'],
        razorId: dynamicData['razor_id'],
        addedDateStr: dynamicData['added_date_str'],
        pickAtShop: dynamicData['pick_at_shop'],
        deliveryPickupDate: dynamicData['delivery_pickup_date'],
        deliveryPickupTime: dynamicData['delivery_pickup_time'],
        transStatus:
            TransactionStatus().fromMap(dynamicData['transaction_status']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['user_id'] = object.userId;
      data['sub_total_amount'] = object.subTotalAmount;
      data['discount_amount'] = object.discountAmount;
      data['balance_amount'] = object.balanceAmount;
      data['coupon_discount_amount'] = object.cuponDiscountAmount;
      data['tax_amount'] = object.taxAmount;
      data['tax_percent'] = object.taxPercent;
      data['shipping_amount'] = object.shippingAmount;
      data['shipping_tax_percent'] = object.shippingTaxPercent;
      data['total_item_amount'] = object.totalItemAmount;
      data['total_item_count'] = object.totalItemCount;
      data['contact_name'] = object.contactName;
      data['contact_phone'] = object.contactPhone;
      data['contact_email'] = contactEmail;
      data['contact_address'] = contactAddress;
      data['contact_area_id'] = contactAreaId;
      data['payment_method'] = object.paymentMethod;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedDate;
      data['updated_user_id'] = object.updatedUserId;
      data['updated_flag'] = object.updatedFlag;
      data['trans_status_id'] = object.transStatusId;
      data['delivery_status_id'] = object.deliveryStatusId;
      data['payment_status_id'] = object.paymentStatusId;
      data['delivery_boy_id'] = object.deliveryBoyId;
      data['currency_symbol'] = object.currencySymbol;
      data['currency_short_form'] = object.currencyShortForm;
      data['trans_code'] = object.transCode;
      data['memo'] = object.memo;
      data['razor_id'] = object.razorId;
      data['added_date_str'] = object.addedDateStr;
      data['pick_at_shop'] = object.pickAtShop;
      data['delivery_pickup_date'] = object.deliveryPickupDate;
      data['delivery_pickup_time'] = object.deliveryPickupTime;
      data['transaction_status'] =
          TransactionStatus().toMap(object.transStatus);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<TransactionHeader> fromMapList(List<dynamic> dynamicDataList) {
    final List<TransactionHeader> subCategoryList = <TransactionHeader>[];

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
  List<Map<String, dynamic>> toMapList(List<TransactionHeader> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (TransactionHeader data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
