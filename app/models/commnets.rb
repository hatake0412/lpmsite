class Commnets < ActiveRecord::Base
  # attr_accessible :title, :body
  belong_to :theme
end
