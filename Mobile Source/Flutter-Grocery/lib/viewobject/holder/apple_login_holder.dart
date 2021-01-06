import 'package:flutter/cupertino.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart';

class AppleLoginParameterHolder extends PsHolder<AppleLoginParameterHolder> {
  AppleLoginParameterHolder(
      {@required this.appleId,
      @required this.userName,
      @required this.userEmail,
      @required this.profilePhotoUrl,
      @required this.deviceToken});

  final String appleId;
  final String userName;
  final String userEmail;
  final String profilePhotoUrl;
  final String deviceToken;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['apple_id'] = appleId;
    map['user_name'] = userName;
    map['user_email'] = userEmail;
    map['profile_photo_url'] = profilePhotoUrl;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  AppleLoginParameterHolder fromMap(dynamic dynamicData) {
    return AppleLoginParameterHolder(
      appleId: dynamicData['apple_id'],
      userName: dynamicData['user_name'],
      userEmail: dynamicData['user_email'],
      profilePhotoUrl: dynamicData['profile_photo_url'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (appleId != '') {
      key += appleId;
    }
    if (userName != '') {
      key += userName;
    }
    if (userEmail != '') {
      key += userEmail;
    }

    if (profilePhotoUrl != '') {
      key += profilePhotoUrl;
    }
    if (deviceToken != '') {
      key += deviceToken;
    }
    return key;
  }
}
