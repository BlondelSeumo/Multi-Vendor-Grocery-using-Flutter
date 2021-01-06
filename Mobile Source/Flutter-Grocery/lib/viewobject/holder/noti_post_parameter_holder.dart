import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class NotiPostParameterHolder extends PsHolder<NotiPostParameterHolder> {
  NotiPostParameterHolder(
      {@required this.notiId,
      @required this.userId,
      @required this.deviceToken});

  final String notiId;
  final String userId;
  final String deviceToken;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['noti_id'] = notiId;
    map['user_id'] = userId;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  NotiPostParameterHolder fromMap(dynamic dynamicData) {
    return NotiPostParameterHolder(
      notiId: dynamicData['noti_id'],
      userId: dynamicData['user_id'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (notiId != '') {
      key += notiId;
    }
    if (userId != '') {
      key += userId;
    }

    if (deviceToken != '') {
      key += deviceToken;
    }
    return key;
  }
}
