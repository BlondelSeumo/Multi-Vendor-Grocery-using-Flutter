import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class PhoneLoginParameterHolder extends PsHolder<PhoneLoginParameterHolder> {
  PhoneLoginParameterHolder(
      {@required this.phoneId,
      @required this.userName,
      @required this.userPhone,
      @required this.deviceToken});

  final String phoneId;
  final String userName;
  final String userPhone;
  final String deviceToken;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['phone_id'] = phoneId;
    map['user_name'] = userName;
    map['user_phone'] = userPhone;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  PhoneLoginParameterHolder fromMap(dynamic dynamicData) {
    return PhoneLoginParameterHolder(
      phoneId: dynamicData['phone_id'],
      userName: dynamicData['user_name'],
      userPhone: dynamicData['user_phone'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userName != '') {
      key += userName;
    }
    if (userPhone != '') {
      key += userPhone;
    }

    if (deviceToken != '') {
      key += deviceToken;
    }
    return key;
  }
}
