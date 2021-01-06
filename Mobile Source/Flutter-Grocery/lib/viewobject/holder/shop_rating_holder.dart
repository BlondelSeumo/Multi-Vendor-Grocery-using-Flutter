import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class ShopRatingParameterHolder extends PsHolder<ShopRatingParameterHolder> {
  ShopRatingParameterHolder(
      {@required this.userId,
      @required this.title,
      @required this.description,
      @required this.rating,
      @required this.shopId});

  final String userId;
  final String title;
  final String description;
  final String rating;
  final String shopId;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['title'] = title;
    map['description'] = description;
    map['rating'] = rating;
    map['shop_id'] = shopId;

    return map;
  }

  @override
  ShopRatingParameterHolder fromMap(dynamic dynamicData) {
    return ShopRatingParameterHolder(
      userId: dynamicData['user_id'],
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
