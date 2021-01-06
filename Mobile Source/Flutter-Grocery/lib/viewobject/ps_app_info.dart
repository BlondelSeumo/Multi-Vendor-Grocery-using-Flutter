import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/delete_object.dart';
import 'package:fluttermultigrocery/viewobject/ps_app_version.dart';
import 'package:fluttermultigrocery/viewobject/user_info.dart';
import 'package:fluttermultigrocery/viewobject/shop_object.dart';

class PSAppInfo extends PsObject<PSAppInfo> {
  PSAppInfo(
      {this.psAppVersion, this.deleteObject, this.userInfo, this.shopObject});
  PSAppVersion psAppVersion;
  UserInfo userInfo;
  List<DeleteObject> deleteObject;
  ShopObject shopObject;

  @override
  String getPrimaryKey() {
    return '';
  }

  @override
  PSAppInfo fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return PSAppInfo(
          psAppVersion: PSAppVersion().fromMap(dynamicData['version']),
          userInfo: UserInfo().fromMap(dynamicData['user_info']),
          deleteObject:
              DeleteObject().fromMapList(dynamicData['delete_history']),
          shopObject: ShopObject().fromMap(dynamicData['shop_obj']));
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['version'] = PSAppVersion().fromMap(object.psAppVersion);
      data['user_info'] = PSAppVersion().fromMap(object.userInfo);
      data['delete_history'] = object.deleteObject.toList();
      data['shop_obj'] = PSAppVersion().fromMap(object.shopInfo);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<PSAppInfo> fromMapList(List<dynamic> dynamicDataList) {
    final List<PSAppInfo> psAppInfoList = <PSAppInfo>[];

    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        if (json != null) {
          psAppInfoList.add(fromMap(json));
        }
      }
    }
    return psAppInfoList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<dynamic> objectList) {
    final List<dynamic> dynamicList = <dynamic>[];
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
