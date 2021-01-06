import 'package:quiver/core.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'default_photo.dart';

class Noti extends PsObject<Noti> {
  Noti(
      {this.id,
      this.description,
      this.message,
      this.addedDate,
      this.addedUserId,
      this.isRead,
      this.addedDateStr,
      this.defaultPhoto});

  String id;
  String description;
  String message;
  String addedDate;
  String addedUserId;
  String isRead;
  String addedDateStr;
  DefaultPhoto defaultPhoto;

  @override
  bool operator ==(dynamic other) => other is Noti && id == other.id;
  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  Noti fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return Noti(
          id: dynamicData['id'],
          description: dynamicData['description'],
          message: dynamicData['message'],
          addedDate: dynamicData['added_date'],
          addedUserId: dynamicData['added_user_id'],
          isRead: dynamicData['is_read'],
          addedDateStr: dynamicData['added_date_str'],
          defaultPhoto: DefaultPhoto().fromMap(dynamicData['default_photo']));
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(Noti object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['message'] = object.message;
      data['description'] = object.description;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['is_read'] = object.isRead;
      data['added_date_str'] = object.addedDateStr;
      data['default_photo'] = DefaultPhoto().toMap(object.defaultPhoto);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<Noti> fromMapList(List<dynamic> dynamicDataList) {
    final List<Noti> subCategoryList = <Noti>[];

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
  List<Map<String, dynamic>> toMapList(List<Noti> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (Noti data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
