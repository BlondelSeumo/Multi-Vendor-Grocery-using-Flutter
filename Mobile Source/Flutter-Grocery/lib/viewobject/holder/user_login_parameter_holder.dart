import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class UserLoginParameterHolder extends PsHolder<UserLoginParameterHolder> {
  UserLoginParameterHolder(
      {@required this.userEmail,
      @required this.userPassword,
      @required this.deviceToken});

  final String userEmail;
  final String userPassword;
  final String deviceToken;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_email'] = userEmail;
    map['user_password'] = userPassword;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  UserLoginParameterHolder fromMap(dynamic dynamicData) {
    return UserLoginParameterHolder(
      userEmail: dynamicData['user_email'],
      userPassword: dynamicData['user_password'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userEmail != '') {
      key += userEmail;
    }
    if (userPassword != '') {
      key += userPassword;
    }

    if (deviceToken != '') {
      key += deviceToken;
    }
    return key;
  }
}
