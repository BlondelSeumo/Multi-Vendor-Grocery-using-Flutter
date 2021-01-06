import 'package:quiver/core.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';

class PSAppVersion extends PsObject<PSAppVersion> {
  PSAppVersion(
      {this.versionNo,
      this.versionForceUpdate,
      this.versionTitle,
      this.versionMessage,
      this.versionNeedClearData});
  String versionNo;
  String versionForceUpdate;
  String versionTitle;
  String versionMessage;
  String versionNeedClearData;

  @override
  bool operator ==(dynamic other) =>
      other is PSAppVersion && versionNo == other.versionNo;

  @override
  int get hashCode => hash2(versionNo.hashCode, versionNo.hashCode);

  @override
  String getPrimaryKey() {
    return versionNo;
  }

  @override
  PSAppVersion fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return PSAppVersion(
          versionNo: dynamicData['version_no'],
          versionForceUpdate: dynamicData['version_force_update'],
          versionTitle: dynamicData['version_title'],
          versionMessage: dynamicData['version_message'],
          versionNeedClearData: dynamicData['version_need_clear_data']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['version_no'] = object.versionNo;
      data['version_force_update'] = object.versionForceUpdate;
      data['version_title'] = object.versionTitle;
      data['version_message'] = object.versionMessage;
      data['version_need_clear_data'] = object.versionNeedClearData;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<PSAppVersion> fromMapList(List<dynamic> dynamicDataList) {
    final List<PSAppVersion> psAppVersionList = <PSAppVersion>[];

    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        if (json != null) {
          psAppVersionList.add(fromMap(json));
        }
      }
    }
    return psAppVersionList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<PSAppVersion> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (PSAppVersion data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
