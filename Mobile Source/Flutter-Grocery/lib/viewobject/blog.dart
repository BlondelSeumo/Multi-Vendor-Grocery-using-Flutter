import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';
import 'default_photo.dart';

class Blog extends PsObject<Blog> {
  Blog(
      {this.id,
      this.name,
      this.description,
      this.status,
      this.addedDate,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.addedDateStr,
      this.defaultPhoto,
      this.shopId});
  String id;
  String name;
  String description;
  String status;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String addedDateStr;
  String shopId;
  DefaultPhoto defaultPhoto;

  @override
  bool operator ==(dynamic other) => other is Blog && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  Blog fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return Blog(
        id: dynamicData['id'],
        name: dynamicData['name'],
        description: dynamicData['description'],
        status: dynamicData['status'],
        addedDate: dynamicData['added_date'],
        addedUserId: dynamicData['added_user_id'],
        updatedDate: dynamicData['updated_date'],
        updatedUserId: dynamicData['updated_user_id'],
        addedDateStr: dynamicData['added_date_str'],
        shopId: dynamicData['shop_id'],
        defaultPhoto: DefaultPhoto().fromMap(dynamicData['default_photo']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(Blog object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['name'] = object.name;
      data['description'] = object.description;
      data['status'] = object.status;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_user_id'] = object.updatedUserId;
      data['added_date_str'] = object.addedDateStr;
      data['shop_id'] = object.shopId;
      data['default_photo'] = DefaultPhoto().toMap(object.defaultPhoto);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<Blog> fromMapList(List<dynamic> dynamicDataList) {
    final List<Blog> blogList = <Blog>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          blogList.add(fromMap(dynamicData));
        }
      }
    }
    return blogList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<Blog> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (Blog data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }
    return mapList;
  }
}
