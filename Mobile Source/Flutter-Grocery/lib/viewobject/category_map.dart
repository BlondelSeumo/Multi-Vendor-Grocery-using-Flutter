import 'package:quiver/core.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_map_object.dart';

class CategoryMap extends PsMapObject<CategoryMap> {
  CategoryMap(
      {this.id, this.mapKey, this.categoryId, int sorting, this.addedDate}) {
    super.sorting = sorting;
  }

  String id;
  String mapKey;
  String categoryId;
  String addedDate;

  @override
  bool operator ==(dynamic other) => other is CategoryMap && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  CategoryMap fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return CategoryMap(
          id: dynamicData['id'],
          mapKey: dynamicData['map_key'],
          categoryId: dynamicData['category_id'],
          sorting: dynamicData['sorting'],
          addedDate: dynamicData['added_date']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['map_key'] = object.mapKey;
      data['category_id'] = object.categoryId;
      data['sorting'] = object.sorting;
      data['added_date'] = object.addedDate;

      return data;
    } else {
      return null;
    }
  }

  @override
  List<CategoryMap> fromMapList(List<dynamic> dynamicDataList) {
    final List<CategoryMap> categoryMapList = <CategoryMap>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          categoryMapList.add(fromMap(dynamicData));
        }
      }
    }
    return categoryMapList;
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

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  List<String> getIdList(List<dynamic> mapList) {
    final List<String> idList = <String>[];
    if (mapList != null) {
      for (dynamic category in mapList) {
        if (category != null) {
          idList.add(category.categoryId);
        }
      }
    }
    return idList;
  }
}
