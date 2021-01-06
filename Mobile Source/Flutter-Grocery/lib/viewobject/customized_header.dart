import 'package:fluttermultigrocery/viewobject/customized_detail.dart';
import 'package:quiver/core.dart';
import 'common/ps_object.dart';

class CustomizedHeader extends PsObject<CustomizedHeader> {
  CustomizedHeader(
      {this.id,
      this.productId,
      this.name,
      this.addedDate,
      this.addedUserId,
      this.updatedDate,
      this.updatedUserId,
      this.updatedFlag,
      this.customizedDetail});
  String id;
  String productId;
  String name;
  String addedDate;
  String addedUserId;
  String updatedDate;
  String updatedUserId;
  String updatedFlag;
  List<CustomizedDetail> customizedDetail;

  @override
  bool operator ==(dynamic other) =>
      other is CustomizedHeader && id == other.id;

  @override
  int get hashCode => hash2(id.hashCode, id.hashCode);

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  CustomizedHeader fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return CustomizedHeader(
        id: dynamicData['id'],
        productId: dynamicData['product_id'],
        name: dynamicData['name'],
        addedDate: dynamicData['added_date'],
        addedUserId: dynamicData['added_user_id'],
        updatedDate: dynamicData['updated_date'],
        updatedUserId: dynamicData['updated_user_id'],
        updatedFlag: dynamicData['updated_flag'],
        customizedDetail:
            CustomizedDetail().fromMapList(dynamicData['customized_detail']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(dynamic object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['product_id'] = object.productId;
      data['name'] = object.name;
      data['added_date'] = object.addedDate;
      data['added_user_id'] = object.addedUserId;
      data['updated_date'] = object.updatedDate;
      data['updated_user_id'] = object.updatedUserId;
      data['updated_flag'] = object.updatedFlag;
      data['customized_detail'] =
          CustomizedDetail().toMapList(object.customizedDetail);

      return data;
    } else {
      return null;
    }
  }

  @override
  List<CustomizedHeader> fromMapList(List<dynamic> dynamicDataList) {
    final List<CustomizedHeader> userLoginList = <CustomizedHeader>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          userLoginList.add(fromMap(dynamicData));
        }
      }
    }
    return userLoginList;
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
