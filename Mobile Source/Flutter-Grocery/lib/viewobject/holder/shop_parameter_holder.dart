import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart';

class ShopParameterHolder extends PsHolder<dynamic> {
  ShopParameterHolder() {
    isFeatured = '0';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;
    lat = '';
    lng = '';
    miles = '';
  }

  String isFeatured;
  String orderBy;
  String orderType;
  String lat;
  String lng;
  String miles;

  ShopParameterHolder getShopNearYouParameterHolder() {
    isFeatured = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;
    lat = '';
    lng = '';
    miles = '10';

    return this;
  }

  ShopParameterHolder getTrendingShopParameterHolder() {
    isFeatured = '';
    orderBy = PsConst.FILTERING_TRENDING;
    orderType = PsConst.FILTERING__DESC;
    lat = '';
    lng = '';
    miles = '';

    return this;
  }

  ShopParameterHolder resetParameterHolder() {
    isFeatured = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;
    lat = '';
    lng = '';
    miles = '';

    return this;
  }

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};
    map['is_featured'] = isFeatured;
    map['order_by'] = orderBy;
    map['order_type'] = orderType;
    map['lat'] = lat;
    map['lng'] = lng;
    map['miles'] = miles;
    return map;
  }

  @override
  dynamic fromMap(dynamic dynamicData) {
    isFeatured = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;
    lat = '';
    lng = '';
    miles = '';

    return this;
  }

  @override
  String getParamKey() {
    const String newshop = 'New Shops';
    const String featured = 'Featured Shops';
    const String popularshop = 'Popular Shops';

    String result = '';

    if (isFeatured != '' && isFeatured != '0') {
      result += featured + ':';
    }

    if (newshop != '') {
      result += newshop + ':';
    }

    if (popularshop != '') {
      result += popularshop + ':';
    }

    if (orderBy != '') {
      result += orderBy + ':';
    }

    if (orderType != '') {
      result += orderType;
    }

    if (lat != '') {
      result += lat + ':';
    }

    if (lng != '') {
      result += lng + ':';
    }

    if (miles != '') {
      result += miles;
    }

    return result;
  }
}
