import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class ChangePasswordParameterHolder
    extends PsHolder<ChangePasswordParameterHolder> {
  ChangePasswordParameterHolder(
      {@required this.userId, @required this.userPassword});

  final String userId;
  final String userPassword;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['user_password'] = userPassword;

    return map;
  }

  @override
  ChangePasswordParameterHolder fromMap(dynamic dynamicData) {
    return ChangePasswordParameterHolder(
      userId: dynamicData['user_id'],
      userPassword: dynamicData['user_password'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userId != '') {
      key += userId;
    }
    if (userPassword != '') {
      key += userPassword;
    }
    return key;
  }
}
