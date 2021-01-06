import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class CouponDiscountParameterHolder
    extends PsHolder<CouponDiscountParameterHolder> {
  CouponDiscountParameterHolder({
    @required this.couponCode,
    @required this.shopId,
  });

  final String couponCode;
  final String shopId;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['coupon_code'] = couponCode;
    map['shop_id'] = shopId;
    return map;
  }

  @override
  CouponDiscountParameterHolder fromMap(dynamic dynamicData) {
    return CouponDiscountParameterHolder(
      couponCode: dynamicData['coupon_code'],
      shopId: dynamicData['shop_id'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (couponCode != '') {
      key += couponCode;
    }
    if (shopId != '') {
      key += shopId;
    }

    return key;
  }
}
