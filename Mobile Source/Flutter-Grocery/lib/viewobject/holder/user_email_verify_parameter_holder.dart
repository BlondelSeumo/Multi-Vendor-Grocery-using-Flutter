import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class EmailVerifyParameterHolder extends PsHolder<EmailVerifyParameterHolder> {
  EmailVerifyParameterHolder({@required this.userId, @required this.code});

  final String userId;
  final String code;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['code'] = code;

    return map;
  }

  @override
  EmailVerifyParameterHolder fromMap(dynamic dynamicData) {
    return EmailVerifyParameterHolder(
      userId: dynamicData['user_id'],
      code: dynamicData['code'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userId != '') {
      key += userId;
    }
    if (code != '') {
      key += code;
    }
    return key;
  }
}
