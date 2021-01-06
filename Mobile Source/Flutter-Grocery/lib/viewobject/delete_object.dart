import 'package:quiver/core.dart';
import 'common/ps_object.dart';

class DeleteObject extends PsObject<DeleteObject> {
  DeleteObject({this.id, this.typeId, this.typeName, this.deletedDate});
  String id;
  String typeId;
  String typeName;
  String deletedDate;

  @override
  bool operator ==(dynamic other) => other is DeleteObject && id == other.id;
  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  DeleteObject fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return DeleteObject(
          id: dynamicData['id'],
          typeId: dynamicData['type_id'],
          typeName: dynamicData['type_name'],
          deletedDate: dynamicData['deleted_date']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['type_id'] = object.id;
      data['type_name'] = object.id;
      data['deleted_date'] = object.id;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<DeleteObject> fromMapList(List<dynamic> dynamicDataList) {
    final List<DeleteObject> deleteObjectList = <DeleteObject>[];

    if (dynamicDataList != null) {
      for (dynamic json in dynamicDataList) {
        deleteObjectList.add(fromMap(json));
      }
    }
    return deleteObjectList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<DeleteObject> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    for (DeleteObject data in objectList) {
      mapList.add(toMap(data));
    }

    return mapList;
  }
}
