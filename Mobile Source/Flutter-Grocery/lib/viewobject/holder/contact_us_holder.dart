import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class ContactUsParameterHolder extends PsHolder<ContactUsParameterHolder> {
  ContactUsParameterHolder({
    @required this.name,
    @required this.email,
    @required this.message,
    @required this.phone,
  });

  final String name;
  final String email;
  final String message;
  final String phone;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['name'] = name;
    map['email'] = email;
    map['message'] = message;
    map['phone'] = phone;
    return map;
  }

  @override
  ContactUsParameterHolder fromMap(dynamic dynamicData) {
    return ContactUsParameterHolder(
      name: dynamicData['name'],
      email: dynamicData['email'],
      message: dynamicData['message'],
      phone: dynamicData['phone'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (name != '') {
      key += name;
    }
    if (email != '') {
      key += email;
    }
    if (message != '') {
      key += message;
    }
    if (phone != '') {
      key += phone;
    }

    return key;
  }
}
