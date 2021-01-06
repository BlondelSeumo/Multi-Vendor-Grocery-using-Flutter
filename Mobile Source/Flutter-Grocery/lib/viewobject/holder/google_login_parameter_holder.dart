import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class GoogleLoginParameterHolder extends PsHolder<GoogleLoginParameterHolder> {
  GoogleLoginParameterHolder(
      {@required this.googleId,
      @required this.userName,
      @required this.userEmail,
      @required this.profilePhotoUrl,
      @required this.deviceToken});

  final String googleId;
  final String userName;
  final String userEmail;
  final String profilePhotoUrl;
  final String deviceToken;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['google_id'] = googleId;
    map['user_name'] = userName;
    map['user_email'] = userEmail;
    map['profile_photo_url'] = profilePhotoUrl;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  GoogleLoginParameterHolder fromMap(dynamic dynamicData) {
    return GoogleLoginParameterHolder(
      googleId: dynamicData['google_id'],
      userName: dynamicData['user_name'],
      userEmail: dynamicData['user_email'],
      profilePhotoUrl: dynamicData['profile_photo_url'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

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
