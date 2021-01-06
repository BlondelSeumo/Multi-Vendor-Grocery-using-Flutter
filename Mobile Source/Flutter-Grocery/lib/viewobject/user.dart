import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/shipping_area.dart';
import 'package:quiver/core.dart';

class User extends PsObject<User> {
  User(
      {this.userId,
      this.userIsSysAdmin,
      this.isShopAdmin,
      this.facebookId,
      this.googleId,
      this.userName,
      this.userEmail,
      this.userPhone,
      this.userPassword,
      this.userAboutMe,
      this.userCoverPhoto,
      this.userProfilePhoto,
      this.roleId,
      this.status,
      this.isBanned,
      this.addedDate,
      this.address,
      this.userLat,
      this.userLng,
      this.deviceToken,
      this.code,
      this.verifyTypes,
      this.addedDateStr,
      this.area});
  String userId;
  String userIsSysAdmin;
  String isShopAdmin;
  String facebookId;
  String googleId;
  String userName;
  String userEmail;
  String userPhone;
  String userPassword;
  String userAboutMe;
  String userCoverPhoto;
  String userProfilePhoto;
  String roleId;
  String status;
  String isBanned;
  String addedDate;
  String address;
  String userLat;
  String userLng;
  String deviceToken;
  String code;
  String verifyTypes;
  String addedDateStr;
  ShippingArea area;

  @override
  bool operator ==(dynamic other) => other is User && userId == other.userId;

  @override
  int get hashCode {
    return hash2(userId.hashCode, userId.hashCode);
  }

  @override
  String getPrimaryKey() {
    return userId;
  }

  @override
  User fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return User(
        userId: dynamicData['user_id'],
        userIsSysAdmin: dynamicData['user_is_sys_admin'],
        isShopAdmin: dynamicData['is_shop_admin'],
        facebookId: dynamicData['facebook_id'],
        googleId: dynamicData['google_id'],
        userName: dynamicData['user_name'],
        userEmail: dynamicData['user_email'],
        userPhone: dynamicData['user_phone'],
        userPassword: dynamicData['user_password'],
        userAboutMe: dynamicData['user_about_me'],
        userCoverPhoto: dynamicData['user_cover_photo'],
        userProfilePhoto: dynamicData['user_profile_photo'],
        roleId: dynamicData['role_id'],
        status: dynamicData['status'],
        isBanned: dynamicData['is_banned'],
        addedDate: dynamicData['added_date'],
        address: dynamicData['user_address'],
        userLat: dynamicData['user_lat'],
        userLng: dynamicData['user_lng'],
        deviceToken: dynamicData['device_token'],
        code: dynamicData['code'],
        verifyTypes: dynamicData['verify_types'],
        addedDateStr: dynamicData['added_date_str'],
        area: ShippingArea().fromMap(dynamicData['user_area']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(User object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['user_id'] = object.userId;
      data['user_is_sys_admin'] = object.userIsSysAdmin;
      data['is_shop_admin'] = object.isShopAdmin;
      data['facebook_id'] = object.facebookId;
      data['google_id'] = object.googleId;
      data['user_name'] = object.userName;
      data['user_email'] = object.userEmail;
      data['user_phone'] = object.userPhone;
      data['user_password'] = object.userPassword;
      data['user_about_me'] = object.userAboutMe;
      data['user_cover_photo'] = object.userCoverPhoto;
      data['user_profile_photo'] = object.userProfilePhoto;
      data['role_id'] = object.roleId;
      data['status'] = object.status;
      data['is_banned'] = object.isBanned;
      data['added_date'] = object.addedDate;
      data['user_address'] = object.address;
      data['user_lat'] = object.userLat;
      data['user_lng'] = object.userLng;
      data['device_token'] = object.deviceToken;
      data['code'] = object.code;
      data['verify_types'] = object.verifyTypes;
      data['added_date_str'] = object.addedDateStr;
      data['user_area'] = ShippingArea().toMap(object.area);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<User> fromMapList(List<dynamic> dynamicDataList) {
    final List<User> subUserList = <User>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          subUserList.add(fromMap(dynamicData));
        }
      }
    }
    return subUserList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<User> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (User data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
