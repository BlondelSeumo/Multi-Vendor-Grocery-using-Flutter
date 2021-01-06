import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';

class UserInfo extends PsObject<UserInfo> {
  UserInfo({
    this.userStatus,
  });

  String userStatus;

  @override
  bool operator ==(dynamic other) =>
      other is UserInfo && userStatus == other.userStatus;

  @override
  int get hashCode => hash2(userStatus.hashCode, userStatus.hashCode);

  @override
  String getPrimaryKey() {
    return userStatus;
  }

  @override
  List<UserInfo> fromMapList(List<dynamic> dynamicDataList) {
    final List<UserInfo> subCategoryList = <UserInfo>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          subCategoryList.add(fromMap(dynamicData));
        }
      }
    }
    return subCategoryList;
  }

  @override
  UserInfo fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return UserInfo(
        userStatus: dynamicData['user_status'],
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(UserInfo object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['user_status'] = object.userStatus;

      return data;
    } else {
      return null;
    }
  }

  @override
  List<Map<String, dynamic>> toMapList(List<UserInfo> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (UserInfo data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }
    return mapList;
  }
}
