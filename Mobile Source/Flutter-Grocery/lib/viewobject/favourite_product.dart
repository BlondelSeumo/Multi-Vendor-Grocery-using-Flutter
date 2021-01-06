import 'package:quiver/core.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_map_object.dart';

class FavouriteProduct extends PsMapObject<FavouriteProduct> {
  FavouriteProduct({this.id, int sorting}) {
    super.sorting = sorting;
  }
  String id;

  @override
  bool operator ==(dynamic other) =>
      other is FavouriteProduct && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  FavouriteProduct fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return FavouriteProduct(
          id: dynamicData['id'], sorting: dynamicData['sorting']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['sorting'] = object.sorting;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<FavouriteProduct> fromMapList(List<dynamic> dynamicDataList) {
    final List<FavouriteProduct> favouriteProductMapList = <FavouriteProduct>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          favouriteProductMapList.add(fromMap(dynamicData));
        }
      }
    }
    return favouriteProductMapList;
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
  List<String> getIdList(List<dynamic> mapList) {
    final List<String> idList = <String>[];
    if (mapList != null) {
      for (dynamic product in mapList) {
        if (product != null) {
          idList.add(product.id);
        }
      }
    }
    return idList;
  }
}
