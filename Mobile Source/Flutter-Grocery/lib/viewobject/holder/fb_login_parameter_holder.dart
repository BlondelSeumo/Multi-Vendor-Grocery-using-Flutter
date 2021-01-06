import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class FBLoginParameterHolder extends PsHolder<FBLoginParameterHolder> {
  FBLoginParameterHolder(
      {@required this.facebookId,
      @required this.userName,
      @required this.userEmail,
      @required this.profileImgId,
      @required this.profilePhotoUrl,
      @required this.deviceToken});

  final String facebookId;
  final String userName;
  final String profileImgId;
  final String userEmail;
  final String profilePhotoUrl;
  final String deviceToken;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['facebook_id'] = facebookId;
    map['user_name'] = userName;
    map['user_email'] = userEmail;
    map['profile_img_id'] = profileImgId;
    map['profile_photo_url'] = profilePhotoUrl;
    map['device_token'] = deviceToken;

    return map;
  }

  @override
  FBLoginParameterHolder fromMap(dynamic dynamicData) {
    return FBLoginParameterHolder(
      facebookId: dynamicData['facebook_id'],
      userName: dynamicData['user_name'],
      userEmail: dynamicData['user_email'],
      profileImgId: dynamicData['profile_img_id'],
      profilePhotoUrl: dynamicData['profile_photo_url'],
      deviceToken: dynamicData['device_token'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (facebookId != '') {
      key += facebookId;
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
    if (profileImgId != '') {
      key += profileImgId;
    }
    if (deviceToken != '') {
      key += deviceToken;
    }
    return key;
  }
}
