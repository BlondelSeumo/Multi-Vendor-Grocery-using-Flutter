import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class ResendCodeParameterHolder extends PsHolder<ResendCodeParameterHolder> {
  ResendCodeParameterHolder({@required this.userEmail});

  final String userEmail;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_email'] = userEmail;

    return map;
  }

  @override
  ResendCodeParameterHolder fromMap(dynamic dynamicData) {
    return ResendCodeParameterHolder(
      userEmail: dynamicData['user_email'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userEmail != '') {
      key += userEmail;
    }
    return key;
  }
}
