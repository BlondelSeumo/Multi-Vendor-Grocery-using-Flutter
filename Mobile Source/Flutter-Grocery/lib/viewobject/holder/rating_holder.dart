import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class RatingParameterHolder extends PsHolder<RatingParameterHolder> {
  RatingParameterHolder(
      {@required this.userId,
      @required this.productId,
      @required this.title,
      @required this.description,
      @required this.rating,
      @required this.shopId});

  final String userId;
  final String productId;
  final String title;
  final String description;
  final String rating;
  final String shopId;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['product_id'] = productId;
    map['title'] = title;
    map['description'] = description;
    map['rating'] = rating;
    map['shop_id'] = shopId;

    return map;
  }

  @override
  RatingParameterHolder fromMap(dynamic dynamicData) {
    return RatingParameterHolder(
      userId: dynamicData['user_id'],
      productId: dynamicData['product_id'],
      title: dynamicData['title'],
      description: dynamicData['description'],
      rating: dynamicData['rating'],
      shopId: dynamicData['shop_id'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userId != '') {
      key += userId;
    }
    if (productId != '') {
      key += productId;
    }

    if (title != '') {
      key += title;
    }
    if (description != '') {
      key += description;
    }
    if (rating != '') {
      key += rating;
    }
    if (shopId != '') {
      key += shopId;
    }
    return key;
  }
}
