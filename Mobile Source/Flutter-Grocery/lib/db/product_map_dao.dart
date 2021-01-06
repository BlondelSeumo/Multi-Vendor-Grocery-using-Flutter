import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';
import 'package:fluttermultigrocery/viewobject/product_map.dart';

class ProductMapDao extends PsDao<ProductMap> {
  ProductMapDao._() {
    init(ProductMap());
  }
  static const String STORE_NAME = 'ProductMap';
  final String _primaryKey = 'id';

  // Singleton instance
  static final ProductMapDao _singleton = ProductMapDao._();

  // Singleton accessor
  static ProductMapDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(ProductMap object) {
    return object.id;
  }

  @override
  Filter getFilter(ProductMap object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
