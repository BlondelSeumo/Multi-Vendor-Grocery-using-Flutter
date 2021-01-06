import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';

class ShopObject extends PsObject<ShopObject> {
  ShopObject({this.ismulti, this.shop});
  String ismulti;
  Shop shop;

  // @override
  // bool operator ==(dynamic other) => other is ShopObject && id == other.id;

  // @override
  // int get hashCode {
  //   return hash2(id.hashCode, id.hashCode);
  // }

  @override
  String getPrimaryKey() {
    return '';
  }

  @override
  ShopObject fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return ShopObject(
        ismulti: dynamicData['is_multi'],
        shop: Shop().fromMap(dynamicData['shop']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(ShopObject object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['is_multi'] = object.ismulti;
      data['shop'] = Shop().toMap(object.shop);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<ShopObject> fromMapList(List<dynamic> dynamicDataList) {
    final List<ShopObject> commentList = <ShopObject>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          commentList.add(fromMap(dynamicData));
        }
      }
    }
    return commentList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<ShopObject> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (ShopObject data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
