import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart';
import 'package:flutter/cupertino.dart';

class GetNotiParameterHolder extends PsHolder<GetNotiParameterHolder> {
  GetNotiParameterHolder({@required this.userId, @required this.deviceToken});

  final String userId;
  final String deviceToken;

  @override
  Map<dynamic, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  GetNotiParameterHolder fromMap(dynamic dynamicData) {
    return GetNotiParameterHolder(
      userId: dynamicData['user_id'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userId != '') {
      key += userId;
    }
    if (deviceToken != '') {
      key += deviceToken;
    }
    return key;
  }
}
