import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:quiver/core.dart';

class Colors extends PsObject<Colors> {
  Colors(
      {this.id,
      this.productId,
      this.colorValue,
      this.addedDate,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.updatedFlag});

  String id;
  String productId;
  String colorValue;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String updatedFlag;

  @override
  bool operator ==(dynamic other) => other is Colors && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  Colors fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return Colors(
          id: dynamicData['id'],
          productId: dynamicData['product_id'],
          colorValue: dynamicData['color_value'],
          addedDate: dynamicData['added_date'],
          addedUserId: dynamicData['added_user_id'],
          updatedDate: dynamicData['updated_date'],
          updatedUserId: dynamicData['updated_user_id'],
          updatedFlag: dynamicData['updated_flag']);
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(Colors object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['product_id'] = object.productId;
      data['color_value'] = object.colorValue;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedFlag;
      data['updated_user_id'] = object.updatedUserId;
      data['updated_flag'] = object.updatedFlag;
      return data;
    } else {
      return null;
    }
  }

  @override
  List<Colors> fromMapList(List<dynamic> dynamicDataList) {
    final List<Colors> colorList = <Colors>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          colorList.add(fromMap(dynamicData));
        }
      }
    }
    return colorList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<Colors> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (Colors data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }
    return mapList;
  }
}
