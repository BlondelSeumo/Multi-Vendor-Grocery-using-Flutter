import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';

class CouponDiscount extends PsObject<CouponDiscount> {
  CouponDiscount({
    this.id,
    this.couponName,
    this.couponCode,
    this.couponAmount,
    this.isPublished,
    this.updatedDate,
    this.addedDate,
    this.addedUserId,
    this.updatedFlag,
    this.addedDateStr,
    this.updatedUserId,
  });
  String id;
  String couponName;
  String couponCode;
  String couponAmount;
  String isPublished;
  String headerComment;
  String updatedDate;
  String addedDate;
  String addedUserId;
  String updatedUserId;
  String addedDateStr;
  String updatedFlag;

  @override
  bool operator ==(dynamic other) => other is CouponDiscount && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  CouponDiscount fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return CouponDiscount(
          id: dynamicData['id'],
          couponName: dynamicData['coupon_name'],
          couponCode: dynamicData['coupon_code'],
          couponAmount: dynamicData['coupon_amount'],
          isPublished: dynamicData['is_published'],
          addedDate: dynamicData['added_date'],
          updatedDate: dynamicData['updated_date'],
          addedUserId: dynamicData['added_user_id'],
          updatedUserId: dynamicData['updated_user_id'],
          addedDateStr: dynamicData['added_date_str'],
          updatedFlag: dynamicData['updated_flag']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(CouponDiscount object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['coupon_name'] = object.couponName;
      data['coupon_code'] = object.couponCode;
      data['coupon_amount'] = object.couponAmount;
      data['is_published'] = object.isPublished;
      data['added_date'] = object.addedDate;
      data['updated_date'] = object.updatedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_user_id'] = object.updatedUserId;
      data['added_date_str'] = object.addedDateStr;
      data['updated_flag'] = object.updatedFlag;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<CouponDiscount> fromMapList(List<dynamic> dynamicDataList) {
    final List<CouponDiscount> commentList = <CouponDiscount>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          commentList.add(fromMap(dynamicData));
        }
      }
    }
    return commentList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<CouponDiscount> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];

    if (objectList != null) {
      for (CouponDiscount data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
