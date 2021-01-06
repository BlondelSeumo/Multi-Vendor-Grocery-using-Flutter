import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:quiver/core.dart';
import 'common/ps_object.dart';

class UserLogin extends PsObject<UserLogin> {
  UserLogin({this.id, this.login, this.user});
  String id;
  bool login;
  User user;

  @override
  bool operator ==(dynamic other) => other is UserLogin && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  UserLogin fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return UserLogin(
        id: dynamicData['id'],
        login: dynamicData['map_key'],
        user: User().fromMap(dynamicData['user']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['map_key'] = object.login;
      data['user'] = User().toMap(object.user);

      return data;
    } else {
      return null;
    }
  }

  @override
  List<UserLogin> fromMapList(List<dynamic> dynamicDataList) {
    final List<UserLogin> userLoginList = <UserLogin>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          userLoginList.add(fromMap(dynamicData));
        }
      }
    }
    return userLoginList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<Map<String, dynamic>> dynamicList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (dynamic data in objectList) {
        if (data != null) {
          dynamicList.add(toMap(data));
        }
      }
    }
    return dynamicList;
  }
}
