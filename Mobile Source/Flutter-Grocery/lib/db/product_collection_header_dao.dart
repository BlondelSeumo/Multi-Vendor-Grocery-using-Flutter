import 'package:fluttermultigrocery/viewobject/product_collection_header.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart';

class ProductCollectionDao extends PsDao<ProductCollectionHeader> {
  ProductCollectionDao._() {
    init(ProductCollectionHeader());
  }

  static const String STORE_NAME = 'ProductCollectionHeader';
  final String _primaryKey = 'id';
  // Singleton instance
  static final ProductCollectionDao _singleton = ProductCollectionDao._();

  // Singleton accessor
  static ProductCollectionDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(ProductCollectionHeader object) {
    return object.id;
  }

  @override
  Filter getFilter(ProductCollectionHeader object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
