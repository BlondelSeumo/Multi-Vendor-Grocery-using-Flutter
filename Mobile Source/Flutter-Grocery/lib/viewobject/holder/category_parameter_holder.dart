import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart';

class CategoryParameterHolder extends PsHolder<dynamic> {
  CategoryParameterHolder() {
    shopId = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
  }

  String orderBy;
  String shopId;

  CategoryParameterHolder getTrendingParameterHolder() {
    shopId = '';
    orderBy = PsConst.FILTERING__TRENDING;

    return this;
  }

  CategoryParameterHolder getLatestParameterHolder() {
    shopId = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;

    return this;
  }

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['shop_id'] = shopId;
    map['order_by'] = orderBy;

    return map;
  }

  @override
  dynamic fromMap(dynamic dynamicData) {
    shopId = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;

    return this;
  }

  @override
  String getParamKey() {
    String result = '';

    if (shopId != '') {
      result += shopId + ':';
    }
    if (orderBy != '') {
      result += orderBy + ':';
    }

    return result;
  }
}
