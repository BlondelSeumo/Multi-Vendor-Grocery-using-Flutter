import 'package:fluttermultigrocery/viewobject/common/ps_holder.dart'
    show PsHolder;
import 'package:flutter/cupertino.dart';

class ProfileUpdateParameterHolder
    extends PsHolder<ProfileUpdateParameterHolder> {
  ProfileUpdateParameterHolder({
    @required this.userId,
    @required this.userEmail,
    @required this.userPhone,
    @required this.userName,
    @required this.userAboutMe,
    @required this.userAddress,
    @required this.userAreaId,
    @required this.userLat,
    @required this.userLng,
  });

  final String userId;
  final String userEmail;
  final String userPhone;
  final String userName;
  final String userAboutMe;
  final String userAddress;
  final String userAreaId;
  final String userLat;
  final String userLng;

  @override
  Map<String, dynamic> toMap() {
    final Map<String, dynamic> map = <String, dynamic>{};

    map['user_id'] = userId;
    map['user_name'] = userName;
    map['user_email'] = userEmail;
    map['user_phone'] = userPhone;
    map['user_about_me'] = userAboutMe;
    map['user_address'] = userAddress;
    map['user_area_id'] = userAreaId;
    map['user_lat'] = userLat;
    map['user_lng'] = userLng;

    return map;
  }

  @override
  ProfileUpdateParameterHolder fromMap(dynamic dynamicData) {
    return ProfileUpdateParameterHolder(
      userId: dynamicData['user_id'],
      userName: dynamicData['user_name'],
      userEmail: dynamicData['user_email'],
      userPhone: dynamicData['user_phone'],
      userAboutMe: dynamicData['user_about_me'],
      userAddress: dynamicData['user_address'],
      userAreaId: dynamicData['user_area_id'],
      userLat: dynamicData['user_lat'],
      userLng: dynamicData['user_lng'],
    );
  }

  @override
  String getParamKey() {
    String key = '';

    if (userId != '') {
      key += userId;
    }
    if (userName != '') {
      key += userName;
    }

    if (userEmail != '') {
      key += userEmail;
    }
    if (userPhone != '') {
      key += userPhone;
    }

    if (userAboutMe != '') {
      key += userAboutMe;
    }

    if (userAddress != '') {
      key += userAddress;
    }
    if (userAreaId != '') {
      key += userAreaId;
    }
    if (userLat != '') {
      key += userLat;
    }
    if (userLng != '') {
      key += userLng;
    }
    return key;
  }
}
