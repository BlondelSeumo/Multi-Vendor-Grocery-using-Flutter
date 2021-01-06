import 'package:fluttermultigrocery/viewobject/common/ps_map_object.dart';
import 'package:quiver/core.dart';

class ShopMap extends PsMapObject<ShopMap> {
  ShopMap({this.id, this.mapKey, this.shopId, int sorting, this.addedDate}) {
    super.sorting = sorting;
  }

  String id;
  String mapKey;
  String shopId;
  String addedDate;

  @override
  bool operator ==(dynamic other) => other is ShopMap && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  ShopMap fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return ShopMap(
          id: dynamicData['id'],
          mapKey: dynamicData['map_key'],
          shopId: dynamicData['shop_id'],
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
      data['shop_id'] = object.shopId;
      data['sorting'] = object.sorting;
      data['added_date'] = object.addedDate;

      return data;
    } else {
      return null;
    }
  }

  @override
  List<ShopMap> fromMapList(List<dynamic> dynamicDataList) {
    final List<ShopMap> shopMapList = <ShopMap>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          shopMapList.add(fromMap(dynamicData));
        }
      }
    }
    return shopMapList;
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
      for (dynamic shop in mapList) {
        if (shop != null) {
          idList.add(shop.shopId);
        }
      }
    }
    return idList;
  }
}
