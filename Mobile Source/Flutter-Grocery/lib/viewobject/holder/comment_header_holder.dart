import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class CommentHeaderParameterHolder
    extends PsHolder<CommentHeaderParameterHolder> {
  CommentHeaderParameterHolder(
      {@required this.userId,
      @required this.productId,
      @required this.headerComment,
      @required this.shopId});

  final String userId;
  final String productId;
  final String headerComment;
  final String shopId;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['product_id'] = productId;
    map['header_comment'] = headerComment;
    map['shop_id'] = shopId;

    return map;
  }

  @override
  CommentHeaderParameterHolder fromMap(dynamic dynamicData) {
    return CommentHeaderParameterHolder(
      userId: dynamicData['user_id'],
      productId: dynamicData['product_id'],
      headerComment: dynamicData['header_comment'],
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

    if (headerComment != '') {
      key += headerComment;
    }
    if (shopId != '') {
      key += shopId;
    }
    return key;
  }
}
