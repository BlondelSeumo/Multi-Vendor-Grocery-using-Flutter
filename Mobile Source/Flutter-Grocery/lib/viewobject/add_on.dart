import 'package:quiver/core.dart';
import 'common/ps_object.dart';
import 'default_photo.dart';

class AddOn extends PsObject<AddOn> {
  AddOn(
      {this.id,
      this.name,
      this.description,
      this.price,
      this.status,
      this.updatedFlag,
      this.defaultPhoto});

  String id;
  String name;
  String description;
  String price;
  String status;
  String updatedFlag;
  DefaultPhoto defaultPhoto;

  @override
  bool operator ==(dynamic other) => other is AddOn && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  AddOn fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return AddOn(
          id: dynamicData['id'],
          name: dynamicData['name'],
          description: dynamicData['description'],
          price: dynamicData['price'],
          status: dynamicData['status'],
          updatedFlag: dynamicData['updated_flag'],
          defaultPhoto: DefaultPhoto().fromMap(dynamicData['default_photo']));
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['name'] = object.name;
      data['description'] = object.description;
      data['price'] = object.price;
      data['status'] = object.status;
      data['updated_flag'] = object.updatedFlag;
      data['default_photo'] = DefaultPhoto().toMap(object.defaultPhoto);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<AddOn> fromMapList(List<dynamic> dynamicDataList) {
    final List<AddOn> addOnList = <AddOn>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          addOnList.add(fromMap(dynamicData));
        }
      }
    }
    return addOnList;
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
