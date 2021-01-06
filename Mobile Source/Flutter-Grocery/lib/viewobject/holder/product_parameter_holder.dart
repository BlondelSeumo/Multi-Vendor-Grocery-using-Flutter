import 'package:fluttermultigrocery/constant/ps_constants.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart';

class ProductParameterHolder extends PsHolder<dynamic> {
  ProductParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '0';
    isDiscount = '0';
    isAvailable = '';
    maxPrice = '';
    minPrice = '';
    overallRating = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;
  }

  String shopId;
  String searchTerm;
  String catId;
  String subCatId;
  String isFeatured;
  String isDiscount;
  String isAvailable;
  String maxPrice;
  String minPrice;
  String overallRating;
  String ratingValueOne;
  String ratingValueTwo;
  String ratingValueThree;
  String ratingValueFour;
  String ratingValueFive;
  String orderBy;
  String orderType;

  // bool isFiltered() {
  //   return !(isAvailable == '' &&
  //       (isDiscount == '0' || isDiscount == '') &&
  //       (isFeatured == '0' || isFeatured == '') &&
  //       minPrice == '' &&
  //       maxPrice == '' &&
  //       overallRating == '' &&
  //       ratingValueFive == '' &&
  //       ratingValueFour == '' &&
  //       ratingValueThree == '' &&
  //       ratingValueTwo == '' &&
  //       ratingValueOne == '' &&
  //       searchTerm == '' &&
  //       shopId == '');
  // }

  bool isFiltered() {
    return !(isAvailable == '' &&
        (isDiscount == '0' || isDiscount == '') &&
        (isFeatured == '0' || isFeatured == '') &&
        minPrice == '' &&
        maxPrice == '' &&
        overallRating == '' &&
        ratingValueFive == '' &&
        ratingValueFour == '' &&
        ratingValueThree == '' &&
        ratingValueTwo == '' &&
        ratingValueOne == '' &&
        searchTerm == '');
  }

  bool isCatAndSubCatFiltered() {
    return !(catId == '' && subCatId == '');
  }

  ProductParameterHolder getDiscountParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '';
    isDiscount = PsConst.ONE;
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  ProductParameterHolder getFeaturedParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = PsConst.ONE;
    isDiscount = '';
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING_FEATURE;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  ProductParameterHolder getTrendingParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '';
    isDiscount = '';
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING_TRENDING;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  ProductParameterHolder getLatestParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '';
    isDiscount = '';
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  ProductParameterHolder getSubCategoryByCatIdParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '';
    isDiscount = '';
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  ProductParameterHolder resetParameterHolder() {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '';
    isDiscount = '';
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};
    map['shop_id'] = shopId;
    map['searchterm'] = searchTerm;
    map['cat_id'] = catId;
    map['sub_cat_id'] = subCatId;
    map['is_featured'] = isFeatured;
    map['is_discount'] = isDiscount;
    map['is_available'] = isAvailable;
    map['max_price'] = maxPrice;
    map['min_price'] = minPrice;
    map['rating_value'] = overallRating;
    map['order_by'] = orderBy;
    map['order_type'] = orderType;
    return map;
  }

  @override
  dynamic fromMap(dynamic dynamicData) {
    shopId = '';
    searchTerm = '';
    catId = '';
    subCatId = '';
    isFeatured = '';
    isDiscount = '';
    isAvailable = '';
    maxPrice = '';
    overallRating = '';
    minPrice = '';
    ratingValueOne = '';
    ratingValueTwo = '';
    ratingValueThree = '';
    ratingValueFour = '';
    ratingValueFive = '';
    orderBy = PsConst.FILTERING__ADDED_DATE;
    orderType = PsConst.FILTERING__DESC;

    return this;
  }

  @override
  String getParamKey() {
    const String discount = 'discount';
    const String featured = 'featured';
    const String available = 'available';
    const String ratingOne = 'rating_one';
    const String ratingTwo = 'rating_two';
    const String ratingThree = 'rating_three';
    const String ratingFour = 'rating_four';
    const String ratingFive = 'rating_five';

    String result = '';

    if (shopId != '') {
      result += shopId + ':';
    }

    if (searchTerm != '') {
      result += searchTerm + ':';
    }

    if (catId != '') {
      result += catId + ':';
    }

    if (subCatId != '') {
      result += subCatId + ':';
    }

    if (isFeatured != '' && isFeatured != '0') {
      result += featured + ':';
    }

    if (isDiscount != '' && isDiscount != '0') {
      result += discount + ':';
    }

    if (isAvailable != '') {
      result += available + ':';
    }

    if (maxPrice != '') {
      result += maxPrice + ':';
    }

    if (overallRating != '') {
      result += overallRating + ':';
    }

    if (minPrice != '') {
      result += minPrice + ':';
    }

    if (ratingValueOne != '') {
      result += ratingOne + ':';
    }

    if (ratingValueTwo != '') {
      result += ratingTwo + ':';
    }

    if (ratingValueThree != '') {
      result += ratingThree + ':';
    }

    if (ratingValueFour != '') {
      result += ratingFour + ':';
    }

    if (ratingValueFive != '') {
      result += ratingFive + ':';
    }

    if (orderBy != '') {
      result += orderBy + ':';
    }

    if (orderType != '') {
      result += orderType;
    }

    return result;
  }
}
